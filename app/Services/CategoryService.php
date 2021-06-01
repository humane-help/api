<?php

namespace App\Services;

use App\Exceptions\UnexpectedErrorException;
use App\Models\Category;
use App\Models\Language;
use App\Repositories\Contracts\CategoryRepository;
use App\Services\Contracts\CategoryService as CategoryServiceInterface;
use App\Services\Traits\ServiceTranslateTable;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;

/**
 * @method bool destroy
 */
class CategoryService  extends BaseService implements CategoryServiceInterface
{
    use ServiceTranslateTable;

    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var CategoryRepository $repository
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
     * Category constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param CategoryRepository $repository
     * @param Language $language
     * @param Logger $logger
     */
    public function __construct(
        DatabaseManager $databaseManager,
        CategoryRepository $repository,
        Language $language,
        Logger $logger
    ) {

        $this->databaseManager     = $databaseManager;
        $this->repository     = $repository;
        $this->logger     = $logger;
        $this->language     = $language;
    }

    /**
     * Create category
     *
     * @param array $data
     * @return Category
     * @throws \Exception
     */
    public function store(array $data)
    {

        $this->beginTransaction();

        try {
            $category = $this->repository->newInstance();
            $category->slug = clean_slug(array_get($data, 'slug'));
            $category->status = array_get($data, 'status', 1);
            $category->parent_id = array_get($data, 'parent_id');
            $category->ord = array_get($data, 'ord');

            if (!$category->save()) {
                throw new UnexpectedErrorException('Category was not saved to the database.');
            }
            $this->logger->info('Category was successfully saved to the database.');

            $this->storeTranslations($category, $data, $this->getTranslationSelectColumnsClosure());
            $this->logger->info('Translations for the Category were successfully saved.', ['category_id' => $category->id]);

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();
        return $category;
    }

    /**
     * Update block in the storage.
     *
     * @param  int  $id
     * @param  array  $data
     *
     * @return Category
     *
     * @throws
     */
    public function update($id, array $data)
    {
        $this->beginTransaction();

        try {
            $category = $this->repository->find($id);
            Arr::set($data, 'slug', clean_slug(array_get($data, 'slug')));
            if (!$category->update($data)) {
                throw new UnexpectedErrorException('An error occurred while updating a category');
            }
            $this->logger->info('Category was successfully updated.');

            $this->storeTranslations($category, $data, $this->getTranslationSelectColumnsClosure());
            $this->logger->info('Category translations was successfully updated.');

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while updating an articles.', [
                'id'   => $id,
                'data' => $data,
            ]);
        }
        $this->commit();
        return $category;
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
            $bufferCategory = [];
            $category = $this->repository->find($id);

            $bufferCategory['id'] = $category->id;
            $bufferCategory['name'] = $category->name;

            if (!$category->delete($id)) {
                throw new UnexpectedErrorException(
                    'Category and category translations was not deleted from database.'
                );
            }
            $this->logger->info('Category category was successfully deleted from database.');
        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while deleting an category.', [
                'id'   => $id,
            ]);
        }
        $this->commit();
        return $bufferCategory;
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
