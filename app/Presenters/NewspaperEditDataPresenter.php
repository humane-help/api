<?php

namespace App\Presenters;

use App\Transformers\NewspaperEditDataTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NewspaperEditDataPresenter.
 *
 * @package namespace App\Presenters;
 */
class NewspaperEditDataPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NewspaperEditDataTransformer();
    }
}
