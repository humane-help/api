<?php

namespace App\Presenters;

use App\Transformers\TechDetailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TechDetailPresenter.
 *
 * @package namespace App\Presenters;
 */
class TechDetailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TechDetailTransformer();
    }
}
