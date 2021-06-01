<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Tech;

/**
 * Class TechDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class TechDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the Article entity.
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
            'translations' => $model->translations,
            'publishedAt' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
            'createdAt' => Carbon::parse(new Carbon($model->created_at, 'UTC'))->format('Y-m-d'),
            'updatedAt' => Carbon::parse(new Carbon($model->updated_at, 'UTC'))->format('Y-m-d'),
        ];
    }
}
