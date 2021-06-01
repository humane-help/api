<?php

namespace App\Transformers;

use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Article;

/**
 * Class ArticleEditDataTransformer.
 *
 * @package namespace App\Transformers;
 */
class ArticleEditDataTransformer extends TransformerAbstract
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
        return array_merge([
            'id' => (int) $model->id,
            'title' => $model->title,
            'status' => $model->status,
            'categoryName' => $model->category_name,
            'author' => $model->author,
            'img' => $model->img,
            'categories' => Category::all(),
            'allTags' => Tag::all(),
            'selectedTags' => $model->getTagIdsAttribute(),
            'content' => $model->content,
            'categoryId' => $model->category_id,
            'publishedAt' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
        ], $model->translations);
    }
}
