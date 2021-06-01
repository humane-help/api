<?php

namespace App\Presenters;

use App\Transformers\NewspaperDetailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NewspaperDetailPresenter.
 *
 * @package namespace App\Presenters;
 */
class NewspaperDetailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NewspaperDetailTransformer();
    }
}
