<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Log\Logger;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\TagRepository as TagRepositoryInterface;

/**
 * Class TagRepository
 * @package App\Repositories
 */
class TagRepository extends Repository implements TagRepositoryInterface
{
    /**
     * Tag constructor.
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
        return Tag::class;
    }

}
