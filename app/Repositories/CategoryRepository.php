<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Log\Logger;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\CategoryRepository as CategoryRepositoryInterface;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    /**
     * Category constructor.
     *
     * @param App $app
     * @param Logger $log
     */
    public function __construct(
        App $app,
        Logger $log
    ) {
        parent::__construct($app, $log);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

}
