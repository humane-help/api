<?php

namespace App\Presenters;

use App\Transformers\ArticleEditDataTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ArticleDetailPresenter.
 *
 * @package namespace App\Presenters;
 */
class ArticleEditDataPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ArticleEditDataTransformer();
    }
}
