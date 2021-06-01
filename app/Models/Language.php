<?php

namespace App\Models;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Language
 *
 * @property string $long_name
 * @property string $short_name
 * @package App\Models
 */
class Language extends Model
{
    use SoftDeletes, TableName;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['long_name', 'short_name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the category for the language.
     *
     * @return HasMany
     */
    public function categoryTranslations(): HasMany
    {
        return $this->hasMany(CategoryTranslations::class);
    }

    /**
     * Get the article for the language.
     *
     * @return HasMany
     */
    public function articleTranslations(): HasMany
    {
        return $this->hasMany(ArticleTranslations::class);
    }

    /**
     * Get the newspaper for the language.
     *
     * @return HasMany
     */
    public function newspaperTranslations(): HasMany
    {
        return $this->hasMany(NewspaperTranslations::class);
    }

    /**
     * Get the tag for the language.
     *
     * @return HasMany
     */
    public function tagTranslations(): HasMany
    {
        return $this->hasMany(TagTranslations::class);
    }
}
