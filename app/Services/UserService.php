<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\UnexpectedErrorException;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use App\Services\Contracts\UserService as UserServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

/**
 * @method bool destroy
 */
class UserService extends BaseService implements UserServiceInterface {
    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var $repository
     */
    protected $repository;

    /**
     * @var Logger $logger
     */
    protected $logger;
    /**
     * User constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param Logger $logger
     * @param UserRepository $repository
     */
    public function __construct(
        DatabaseManager $databaseManager,
        Logger $logger,
        UserRepository $repository
    )
    {
        parent::__construct($databaseManager, $logger, $repository);
    }

    /**
     * Find all categories
     *
     * @return Object
     */
    public function findAll()
    {
        return $this->repository->all();
    }

    /**
     * Find one category
     *
     * @param int $id
     *
     * @return Category
     * @throws NotFoundException
     */
    public function findOne(int $id)
    {
        $category = $this->repository->find($id);
        if (!$category) {
            throw new NotFoundException('Category was not found!');
        }
        return $category;
    }

    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     *
     * @return Category
     *
     * @throws
     */
    public function store(array $data)
    {
        $this->beginTransaction();

        try {
            $data = Arr::set($data, 'password', Hash::make(Arr::get($data, 'password')));
            $user = $this->repository->newInstance()->create($data);

            if (!$user) {
                throw new UnexpectedErrorException('Category was not saved to the database.');
            }
            $this->logger->info('Category was successfully saved to the database.');

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $this->findOne($user->id);
    }

    /**
     * Update a User data
     *
     * @param int $id
     * @param array $data
     * @return Category|User
     * @throws NotFoundException
     */
    public function update($id, array $data)
    {
        $this->beginTransaction();

        try {

            $user = $this->repository->find($id)->update($data, $id);

            if (!$user) {
                throw new UnexpectedErrorException('Category was not updated to the database.');
            }
            $this->logger->info('Category was successfully updated to the database.');

        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $this->findOne($user->id);
    }

    /**
     * Delete a User
     *
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        //
    }
}
