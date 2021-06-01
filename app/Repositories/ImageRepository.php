<?php

namespace App\Repositories;

use App\Models\Image;
use Illuminate\Log\Logger;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\ImageRepository as ImageRepositoryInterface;

/**
 * Class ImageRepository
 * @package App\Repositories
 */
class ImageRepository extends Repository implements ImageRepositoryInterface
{
    /**
     * Image constructor.
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
        return Image::class;
    }

}
