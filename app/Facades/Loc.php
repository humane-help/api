<?php

namespace App\Facades;

use App\Locale;
use Illuminate\Support\Facades\Facade;

class Loc extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return Locale::class; }
}
