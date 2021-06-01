<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Article;

/**
 * Class ArticleListTransformer.
 *
 * @package namespace App\Transformers;
 */
class ArticleUiDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the Article entity.
     *
     * @param \App\Models\Article $model
     *
     * @return array
     */
    public function transform(Article $model)
    {
        return [
            [
                'id' => (int) $model->id,
                'title' => $model->title,
                'description' => $model->description,
                'status' => $model->status,
                'url' => $model->url,
                'slug' => $model->slug,
                'category_name' => $model->category_name,
                'category_slug' => $model->category->slug,
                'category_id' => $model->category_id,
                'content' => $model->content,
                'author' => $model->author,
                'img' => $model->img,
                'published_at' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
                'created_at' => Carbon::parse(new Carbon($model->created_at, 'UTC'))->format('Y-m-d'),
                'updated_at' => Carbon::parse(new Carbon($model->updated_at, 'UTC'))->format('Y-m-d'),
            ]
        ];
    }
}
