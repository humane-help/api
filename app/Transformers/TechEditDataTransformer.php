<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Tech;

/**
 * Class TechEditDataTransformer.
 *
 * @package namespace App\Transformers;
 */
class TechEditDataTransformer extends TransformerAbstract
{
    /**
     * Transform the Tech entity.
     *
     * @param \App\Models\Tech $model
     *
     * @return array
     */
    public function transform(Tech $model)
    {
        return array_merge([
            'id' => (int) $model->id,
            'status' => $model->status,
            'link' => $model->link,
            'categoryId' => $model->category_id,
            'publishedAt' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
        ], $model->translations);
    }
}
