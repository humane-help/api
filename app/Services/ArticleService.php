<?php

namespace App\Services;

use App\Exceptions\UnexpectedErrorException;
use App\Helpers\FileHelper;
use App\Models\Article;
use App\Models\Language;
use App\Repositories\Contracts\ArticleRepository;
use App\Services\Contracts\ArticleService as ArticleServiceInterface;
use App\Services\Traits\ServiceTranslateTable;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;
use App\Services\Contracts\TelegramService;
use Illuminate\Support\Str;

/**
 * @method bool destroy
 */
class ArticleService  extends BaseService implements ArticleServiceInterface
{
    use ServiceTranslateTable;

    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var ArticleRepository $repository
     */
    protected $repository;

    /**
     * Language $language
     */
    protected $language;

    /**
     * @var Logger $logger
     */
    protected $logger;

    /**
     * @var FileHelper $fileHelper
     */
    protected $fileHelper;

    /**
     * @var TelegramService
     */
    protected $telegramService;

    /**
     * ArticleService constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param ArticleRepository $repository
     * @param Language $language
     * @param Logger $logger
     * @param FileHelper $fileHelper
     * @param TelegramService $telegramService
     */
    public function __construct(
        DatabaseManager $databaseManager,
        ArticleRepository $repository,
        Language $language,
        Logger $logger,
        FileHelper $fileHelper,
        TelegramService $telegramService
    ) {

        $this->databaseManager = $databaseManager;
        $this->repository      = $repository;
        $this->logger          = $logger;
        $this->language        = $language;
        $this->fileHelper      = $fileHelper;
        $this->telegramService = $telegramService;
    }

    /**
     * Create article
     *
     * @param array $data
     * @return Article
     * @throws \Exception
     */
    public function store(array $data)
    {
        $this->beginTransaction();
        try {
            /** @var Article $article */
            $article = $this->repository->newInstance();
            $slug = Str::slug(array_get($data, 'uz.title'));
            $article->slug = clean_slug($slug);
            $article->status = Article::STATUS_DRAFT;
            $article->category_id = array_get($data, 'category_id');
            $article->published_at = array_get($data, 'published_at');
            $article->author = array_get($data, 'author');
            $article->is_main = json_decode(array_get($data, 'is_main', 0));
            $article->img = array_get($data, 'img');
            if (!$article->save()) {
                throw new UnexpectedErrorException('Article was not saved to the database.');
            }
            $tagIds = array_get($data, 'tags');

            if ($tagIds) {
                if (is_array($tagIds)) {
                    $article->tags()->sync($tagIds);
                } else {
                    $article->tags()->sync(explode(',', $tagIds));
                }
            }
            $this->logger->info('Article was successfully saved to the database.');

            $this->storeTranslations($article, $data, $this->getTranslationSelectColumnsClosure());
            $this->logger->info('Translations for the Article were successfully saved.', ['article_id' => $article->id]);

            /*$this->telegramService->sendMessageChannel(
                $article->title,
                $article->url,
                $article->img,
                $article->category->name
            );*/
        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();
        return $article;
    }

    protected function storeImage(array $data) {

        $dataFields =[];
        if(Arr::has($data,'img')) {
            $uploadedFile  = $data['img'];
            $dataFields['img'] = $this->fileHelper->upload($uploadedFile,'img\content');
        }
        return $dataFields;
    }

    /**
     * Update block in the storage.
     *
     * @param  int  $id
     * @param  array  $data
     *
     * @return Article
     *
     * @throws
     */
    public function update($id, array $data)
    {
        $this->beginTransaction();
        try {
            $article = $this->repository->find($id);

            $article->category_id = array_get($data, 'category_id');
            $article->published_at = array_get($data, 'published_at');
            $article->author = array_get($data, 'author');
            $article->is_main = json_decode(array_get($data, 'is_main', 0));
            $article->img = array_get($data, 'img');

            if (!$article->save()) {
                throw new UnexpectedErrorException('An error occurred while updating a article');
            }
            $tagIds = array_get($data, 'tags');
            if ($tagIds) {
                if (is_array($tagIds)) {
                    $article->tags()->sync($tagIds);
                } else {
                    $article->tags()->sync(explode(',', $tagIds));
                }

            }
            $this->logger->info('Article was successfully updated.');

            $this->storeTranslations($article, $data, $this->getTranslationSelectColumnsClosure());
            $this->logger->info('Article translations was successfully updated.');

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while updating an articles.', [
                'id'   => $id,
                'data' => $data,
            ]);

        }
        $this->commit();
        return $article;
    }
    /**
     * Delete block in the storage.
     *
     * @param  int  $id
     *
     * @return array
     *
     * @throws
     */
    public function delete($id)
    {

        $this->beginTransaction();

        try {
            $bufferArticle = [];
            $article = $this->repository->find($id);

            $bufferArticle['id'] = $article->id;
            $bufferArticle['name'] = $article->name;

            if (!$article->delete($id)) {
                throw new UnexpectedErrorException(
                    'Article and article translations was not deleted from database.'
                );
            }
            $this->logger->info('Article article was successfully deleted from database.');
        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while deleting an article.', [
                'id'   => $id,
            ]);
        }
        $this->commit();
        return $bufferArticle;
    }

    /**
     * Closure that handles translation for storing in the database.
     *
     * @return \Closure
     */
    protected function getTranslationSelectColumnsClosure()
    {
        return function ($translation) {
            return [
                'title' => Arr::get($translation, 'title'),
                'description' => Arr::get($translation, 'description'),
                'content' => Arr::get($translation, 'content'),
                'source' => Arr::get($translation, 'source'),
            ];
        };
    }
}
