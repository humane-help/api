<?php

namespace App\Services\Contracts;

use App\Models\Image;

/**
 * Interface ImageService
 *
 * @package App\Services\Contracts
 * @method bool destroy(int)
 */
interface ImageService extends BaseService
{
    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     * @return Image
     */
    public function upload(array $data);
}
