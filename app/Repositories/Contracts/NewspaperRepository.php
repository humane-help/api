<?php

namespace App\Repositories\Contracts;

/**
 * Interface NewspaperRepository
 * @package App\Repositories\Contracts
 */
interface NewspaperRepository extends Repository
{

    /**
     * Get orders that have only passed statuses.
     *
     * @return $this
     */
    public function statusesScope(array $statusIds);
}
