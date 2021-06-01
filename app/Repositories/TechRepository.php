<?php

namespace App\Repositories;

use App\Models\Tech;
use Illuminate\Log\Logger;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\TechRepository as TechRepositoryInterface;

/**
 * Class TechRepository
 * @package App\Repositories
 */
class TechRepository extends Repository implements TechRepositoryInterface
{
    /**
     * Tech constructor.
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
        return Tech::class;
    }


}
