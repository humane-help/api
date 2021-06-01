<?php

namespace App\Services\Contracts;

use App\Models\Tech;

/**
 * Interface TechService
 *
 * @property string $link
 * @package App\Services\Contracts
 * @method bool destroy(int)
 */
interface TechService extends BaseService
{
    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     * @return Tech
     */
    public function store(array $data);

    /**
     * Update block in the storage.
     *
     * @param  int  $id
     * @param  array  $data
     * @return Tech
     */
    public function update($id, array $data);

    /**
     * Update block in the storage.
     *
     * @param  int  $id
     * @return array
     */
    public function delete($id);
}
