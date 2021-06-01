<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Newspaper;

/**
 * Class NewspaperEditDataTransformer.
 *
 * @package namespace App\Transformers;
 */
class NewspaperEditDataTransformer extends TransformerAbstract
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
        $selectedQuestions = explode(',', $model->questions);
        $questionData = [];
        foreach ($selectedQuestions as $question) {
            $item = $question ? \App\Models\Newspaper::find($question) : false;
            if ($item) {
                array_push($questionData, [
                    'id' => $item->id,
                    'title' => $item->title
                ]);
            }
        }

        return array_merge([
            'id' => (int) $model->id,
            'status' => $model->status,
            'type' => $model->type,
            'questions' => explode(',', $model->questions),
            'questionSort' => $questionData,
            'advantages' => explode(',', $model->advantages),
            'file' => $model->file,
            'img' => $model->img,
            'categoryId' => $model->category_id,
            'publishedAt' => Carbon::parse(new Carbon($model->published_at, 'UTC'))->format('Y-m-d'),
        ], $model->translations);
    }
}
