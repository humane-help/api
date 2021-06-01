<?php

namespace App\Repositories\Criteria\Status;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class StatusesCriteria
 */
class StatusesCriteria extends RequestCriteria
{
    /**
     * Apply criteria in query repository
     *
     * @param \Prettus\Repository\Contracts\RepositoryInterface $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (isset($repository->statuses) && $statuses = $repository->statuses) {
            return $model->whereIn('type', is_array($statuses) ? $statuses : [$statuses]);
        }
    }
}
