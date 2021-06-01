<?php

namespace App\Presenters;

use App\Transformers\TechEditDataTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TechEditDataPresenter.
 *
 * @package namespace App\Presenters;
 */
class TechEditDataPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TechEditDataTransformer();
    }
}
