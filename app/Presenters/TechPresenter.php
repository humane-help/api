<?php

namespace App\Presenters;

use App\Transformers\TechListTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TechPresenter.
 *
 * @package namespace App\Presenters;
 */
class TechPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TechListTransformer();
    }
}
