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
class ArticleDetailTransformer extends TransformerAbstract
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
            'id' => (int) $model->id,
            'title' => $model->title,
            'status' => $model->status,
            'categoryName' => $model->category_name,
            'category_id' => $model->category_id,
            'content' => $model->content,
            'author' => $model->author,
            'img' => $model->img,
            'translations' => $model->translations,
            'publishedAt' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
            'createdAt' => Carbon::parse(new Carbon($model->created_at, 'UTC'))->format('Y-m-d'),
            'updatedAt' => Carbon::parse(new Carbon($model->updated_at, 'UTC'))->format('Y-m-d'),
        ];
    }
}
