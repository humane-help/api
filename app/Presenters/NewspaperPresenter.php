<?php

namespace App\Presenters;

use App\Transformers\NewspaperListTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NewspaperPresenter.
 *
 * @package namespace App\Presenters;
 */
class NewspaperPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NewspaperListTransformer();
    }
}
