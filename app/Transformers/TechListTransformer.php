<?php

namespace App\Transformers;

use App\Models\Tech;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class TechListTransformer.
 *
 * @package namespace App\Transformers;
 */
class TechListTransformer extends TransformerAbstract
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
        return [
            'id' => (int) $model->id,
            'title' => $model->title,
            'status' => $model->status,
            'link' => $model->link,
            'publishedAt' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
            'createdAt' => Carbon::parse(new Carbon($model->created_at, 'UTC'))->format('Y-m-d'),
            'updatedAt' => Carbon::parse(new Carbon($model->updated_at, 'UTC'))->format('Y-m-d'),
        ];
    }
}
