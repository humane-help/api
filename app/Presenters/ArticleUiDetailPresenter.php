<?php

namespace App\Presenters;

use App\Transformers\ArticleDetailTransformer;
use App\Transformers\ArticleUiDetailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ArticleDetailPresenter.
 *
 * @package namespace App\Presenters;
 */
class ArticleUiDetailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ArticleUiDetailTransformer();
    }
}
