<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Newspaper;

/**
 * Class NewspaperDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class NewspaperDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the Article entity.
     *
     * @param \App\Models\Newspaper $model
     *
     * @return array
     */
    public function transform(Newspaper $model)
    {
        return [
            'id' => (int) $model->id,
            'title' => $model->title,
            'mini_desc' => $model->mini_desc,
            'content' => $model->content,
            'technologies' => $model->technologies,
            'status' => $model->status,
            'file' => $model->file,
            'img' => $model->img,
            'translations' => $model->translations,
            'publishedAt' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
            'createdAt' => Carbon::parse(new Carbon($model->created_at, 'UTC'))->format('Y-m-d'),
            'updatedAt' => Carbon::parse(new Carbon($model->updated_at, 'UTC'))->format('Y-m-d'),
        ];
    }
}
