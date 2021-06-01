<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepository as UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

}
