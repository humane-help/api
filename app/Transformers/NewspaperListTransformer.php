<?php

namespace App\Transformers;

use App\Models\Newspaper;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class NewspaperListTransformer.
 *
 * @package namespace App\Transformers;
 */
class NewspaperListTransformer extends TransformerAbstract
{
    /**
     * Transform the Newspaper entity.
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
            'status' => $model->status,
            'author' => $model->author,
            'type' => $model->type,
            'mini_desc' => $model->mini_desc,
            'img' => $model->img,
            'file' => $model->file,
            'publishedAt' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
            'createdAt' => Carbon::parse(new Carbon($model->created_at, 'UTC'))->format('Y-m-d'),
            'updatedAt' => Carbon::parse(new Carbon($model->updated_at, 'UTC'))->format('Y-m-d'),
        ];
    }
}
