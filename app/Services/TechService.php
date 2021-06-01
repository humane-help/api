<?php

namespace App\Services;

use App\Exceptions\UnexpectedErrorException;
use App\Helpers\FileHelper;
use App\Models\Tech;
use App\Models\Language;
use App\Repositories\Contracts\TechRepository;
use App\Services\Contracts\TechService as TechServiceInterface;
use App\Services\Traits\ServiceTranslateTable;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;

/**
 * @method bool destroy
 */
class TechService  extends BaseService implements TechServiceInterface
{
    use ServiceTranslateTable;

    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var TechRepository $repository
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
     * @var Logger $logger
     */
    protected $fileHelper;

    /**
     * TechService constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param TechRepository $repository
     * @param Language $language
     * @param Logger $logger
     * @param FileHelper $fileHelper
     */
    public function __construct(
        DatabaseManager $databaseManager,
        TechRepository $repository,
        Language $language,
        Logger $logger,
        FileHelper $fileHelper
    ) {

        $this->databaseManager     = $databaseManager;
        $this->repository     = $repository;
        $this->logger     = $logger;
        $this->language     = $language;
        $this->fileHelper     = $fileHelper;
    }

    /**
     * Create tech
     *
     * @param array $data
     * @return Tech
     * @throws \Exception
     */
    public function store(array $data)
    {
        $this->beginTransaction();

        try {
            $tech = $this->repository->newInstance();
            $tech->status = Tech::STATUS_ACTIVE;
            $tech->link = clean_youtube_link(array_get($data, 'link'));
            $tech->published_at     = array_get($data, 'published_at', Carbon::now());

            if (!$tech->save()) {
                throw new UnexpectedErrorException('Tech was not saved to the database.');
            }
            $tagIds = array_get($data, 'tags');
            if ($tagIds) {
                $tech->tags()->sync(explode(',', $tagIds));
            }
            $this->logger->info('Tech was successfully saved to the database.');

            $this->storeTranslations($tech, $data, $this->getTranslationSelectColumnsClosure());
            $this->logger->info('Translations for the Tech were successfully saved.', ['tech_id' => $tech->id]);

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }
        $this->commit();
        return $tech;
    }

    /**
     * Update block in the storage.
     *
     * @param  int  $id
     * @param  array  $data
     *
     * @return Tech
     *
     * @throws
     */
    public function update($id, array $data)
    {
        $this->beginTransaction();

        try {
            $tech = $this->repository->find($id);
            $tech->link = clean_youtube_link(array_get($data, 'link'));
            $tech->published_at     = array_get($data, 'published_at', Carbon::now());

            if (!$tech->save()) {
                throw new UnexpectedErrorException('An error occurred while updating a tech');
            }

            $tagIds = array_get($data, 'tags');
            if ($tagIds) {
                $tech->tags()->sync(explode(',', $tagIds));
            }
            $this->logger->info('Tech was successfully updated.');

            $this->storeTranslations($tech, $data, $this->getTranslationSelectColumnsClosure());
            $this->logger->info('Tech translations was successfully updated.');

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while updating an articles.', [
                'id'   => $id,
                'data' => $data,
            ]);

        }
        $this->commit();
        return $tech;
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
            $bufferTech = [];
            $tech = $this->repository->find($id);

            $bufferTech['id'] = $tech->id;
            $bufferTech['name'] = $tech->name;

            if (!$tech->delete($id)) {
                throw new UnexpectedErrorException(
                    'Tech and tech translations was not deleted from database.'
                );
            }
            $this->logger->info('Tech tech was successfully deleted from database.');
        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while deleting an tech.', [
                'id'   => $id,
            ]);
        }
        $this->commit();
        return $bufferTech;
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
            ];
        };
    }
}
