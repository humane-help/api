<?php

namespace App\Presenters;

use App\Transformers\ArticleListTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PublisherPresenter.
 *
 * @package namespace App\Presenters;
 */
class ArticlePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ArticleListTransformer();
    }
}
