<?php

namespace App\Models\Traits;

use App;
use App\Models\Language;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait TranslationTable
 * @package App\Models\Traits
 */
trait TranslationTable
{
    /**
     * Get the translations for the content item.
     *
     * @return HasMany
     */
    public function translationsAll()
    {
        return $this->hasMany($this->translatableModel, 'item_id');
    }

    /**
     * @return array
     */
    public function getTranslationsAttribute()
    {
        $lang = [];
        $data = [];
        foreach ($this->translationsAll as $item) {
            $translate = $item->toArray();

            foreach ($translate as $key => $value) {
                if ($key == 'language') {
                    continue;
                }
                if ($key) {
                    $lang[$key] = $value;
                    $data[$item->language->short_name] = $lang;
                }
            }
        }
        return $data;
    }

    /**
     * The languages that belong to the content item.
     *
     * @return BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(
            Language::class,
            call_user_func([$this->translatableModel, 'getTableName']),
            'item_id'
        );
    }

    /**
     * Get translations
     *
     * @param  string  $field
     * @param  string  $default
     * @param  string  $defaultLang
     * @return string
     */
    public function translate($field, $default = null, $defaultLang = null, $addedLang = null)
    {
        $languges = Language::all();
        $translation = $this->getTranslation($field, $this->getLangAttribute());

        if (is_null($translation) && is_null($defaultLang)) {
            $translation = $this->getTranslation($field, $this->getFallbackLang());
        }

        if (!$translation) {
            foreach ($languges as $language) {
                $translation = $this->getTranslation($field, $language->short_name);
                if ($translation) {
                    break;
                }
            }
        }

        if ($addedLang) {
            $translation = $this->getTranslation($field, $addedLang);
        }

        return $translation ?: $default;
    }

    /**
     * Get translated field for the specified language.
     *
     * @param $field
     * @param $lang
     * @return null
     */
    public function getTranslation($field, $lang)
    {
        $translation = $this->translationsAll->filter(function ($translation) use ($lang) {
            return $translation->language && $translation->language->short_name == $lang;
        })->first();

        return $translation && isset($translation->$field) && !empty($translation->$field) &&  $translation->$field !== "null" &&  $translation->$field !== "undefined" ?
            $translation->$field :
            "";
    }

    /**
     * Returns current language.
     *
     * @return string
     */
    protected function getLangAttribute()
    {
        return \Illuminate\Support\Facades\App::getLocale();
    }

    /**
     * Returns fallback language.
     *
     * @return mixed
     */
    protected function getFallbackLang()
    {
        return config('app.fallback_locale');
    }
}
