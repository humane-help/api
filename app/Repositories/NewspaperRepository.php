<?php

namespace App\Repositories;

use App\Models\Newspaper;
use App\Repositories\Criteria\Status\StatusesCriteria;
use Illuminate\Log\Logger;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\NewspaperRepository as NewspaperRepositoryInterface;

/**
 * Class NewspaperRepository
 * @package App\Repositories
 */
class NewspaperRepository extends Repository implements NewspaperRepositoryInterface
{
    /**
     * Newspaper constructor.
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
        return Newspaper::class;
    }


    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'type'
    ];


    /**
     * Get Campaign that have passed statuses.
     *
     * @param $statuses
     * @return CampaignRepositoryEloquent
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function statusesScope($statuses)
    {
        $this->statuses = $statuses;

        return $this->pushCriteria(app(StatusesCriteria::class));
    }

}
