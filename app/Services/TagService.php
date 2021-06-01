<?php

namespace App\Services;

use App\Exceptions\UnexpectedErrorException;
use App\Models\Tag;
use App\Models\Language;
use App\Repositories\Contracts\TagRepository;
use App\Services\Contracts\TagService as TagServiceInterface;
use App\Services\Traits\ServiceTranslateTable;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @method bool destroy
 */
class TagService  extends BaseService implements TagServiceInterface
{
    use ServiceTranslateTable;

    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var TagRepository $repository
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
     * Tag constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param TagRepository $repository
     * @param Language $language
     * @param Logger $logger
     */
    public function __construct(
        DatabaseManager $databaseManager,
        TagRepository $repository,
        Language $language,
        Logger $logger
    ) {

        $this->databaseManager     = $databaseManager;
        $this->repository     = $repository;
        $this->logger     = $logger;
        $this->language     = $language;
    }

    /**
     * Create tag
     *
     * @param array $data
     * @return Tag
     * @throws \Exception
     */
    public function store(array $data)
    {

        $this->beginTransaction();

        try {
            $tag           = $this->repository->newInstance();
            $tag->slug = array_get($data, 'slug', Str::random(9));
            $tag->status     = array_get($data, 'status', 1);

            if (!$tag->save()) {
                throw new UnexpectedErrorException('Tag was not saved to the database.');
            }
            $this->logger->info('Tag was successfully saved to the database.');

            $this->storeTranslations($tag, $data, $this->getTranslationSelectColumnsClosure());
            $this->logger->info('Translations for the Tag were successfully saved.', ['tag_id' => $tag->id]);

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();
        return $tag;
    }

    /**
     * Update block in the storage.
     *
     * @param  int  $id
     * @param  array  $data
     *
     * @return Tag
     *
     * @throws
     */
    public function update($id, array $data)
    {
        $this->beginTransaction();

        try {
            $tag = $this->repository->find($id);
            if (!$tag->update($data)) {
                throw new UnexpectedErrorException('An error occurred while updating a tag');
            }
            $this->logger->info('Tag was successfully updated.');

            $this->storeTranslations($tag, $data, $this->getTranslationSelectColumnsClosure());
            $this->logger->info('Tag translations was successfully updated.');

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while updating an articles.', [
                'id'   => $id,
                'data' => $data,
            ]);

        }
        $this->commit();
        return $tag;
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
            $bufferTag = [];
            $tag = $this->repository->find($id);

            $bufferTag['id'] = $tag->id;
            $bufferTag['name'] = $tag->name;

            if (!$tag->delete($id)) {
                throw new UnexpectedErrorException(
                    'Tag and tag translations was not deleted from database.'
                );
            }
            $this->logger->info('Tag tag was successfully deleted from database.');
        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while deleting an tag.', [
                'id'   => $id,
            ]);
        }
        $this->commit();
        return $bufferTag;
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
                'name' => Arr::get($translation, 'name'),
            ];
        };
    }
}
