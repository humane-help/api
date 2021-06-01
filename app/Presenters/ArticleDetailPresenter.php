<?php

namespace App\Presenters;

use App\Transformers\ArticleDetailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ArticleDetailPresenter.
 *
 * @package namespace App\Presenters;
 */
class ArticleDetailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ArticleDetailTransformer();
    }
}
