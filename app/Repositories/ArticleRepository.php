<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Log\Logger;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\ArticleRepository as ArticleRepositoryInterface;

/**
 * Class ArticleRepository
 * @package App\Repositories
 */
class ArticleRepository extends Repository implements ArticleRepositoryInterface
{
    /**
     * Article constructor.
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
     * @var string[]
     */
    protected $fieldSearchable = [
        'status'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }

}
