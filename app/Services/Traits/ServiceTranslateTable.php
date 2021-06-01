<?php

namespace App\Services\Traits;

use App\Models\Language;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait ServiceTranslateTable
{
    /**
     * @var Language $language
     */
    protected $language;

    /**
     * Store translations in the database.
     *
     * @param  Model  $model
     * @param  array  $data
     * @param  Closure  $handler
     * @param  bool  $detaching
     * @return void
     */
    protected function storeTranslations(Model $model, array $data, Closure $handler, $detaching = true)
    {
        $model->languages()->sync($this->getTranslations($data, $handler), $detaching);
        $model->touch();
    }

    /**
     * Format translations to store in the database.
     *
     * @param array $data
     * @param Closure $handler
     * @return array
     */
    protected function getTranslations(array $data, Closure $handler)
    {
        $translations = [];

        foreach ($this->language->all() as $language) {
            $translation = Arr::get($data, $language->short_name);
            $translation = array_filter(call_user_func($handler, $translation));

            if ($translation) {
                Arr::set($translations, $language->id, $translation);
            }
        }
        return $translations;
    }
}
