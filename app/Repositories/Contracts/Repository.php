<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface Repository
 * @package App\Repositories\Contracts
 */
interface Repository extends RepositoryCriteriaInterface, RepositoryInterface
{
    /**
     * Retrieve the "count" result of the query.
     *
     * @param  array  $where
     * @param  string  $columns
     * @return int
     */
    public function count(array $where = [], $columns = '*');

    /**
     * Retrieve the "sum" result of the query.
     *
     * @param  string  $columns
     * @return int
     */
    public function sum($columns = '*');

    /**
     * Retrieve the "avg" result of the query.
     *
     * @param  string  $columns
     * @return int
     */
    public function avg($columns = '*');

    /**
     * Reset all criteria, scopes and model.
     *
     * @return $this
     */
    public function reset();
}
