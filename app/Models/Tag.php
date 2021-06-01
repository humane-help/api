<?php

namespace App\Models;

use App\Models\Traits\TableName;
use App\Models\Traits\TranslationTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use TableName, TranslationTable;

    /**
     * Status disabled
     */
    const STATUS_DISABLED = 0;

    /**
     * Active status
     */
    const STATUS_ACTIVE = 1;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * Related model that stores translations for the model.
     *
     * @var string
     */
    protected $translatableModel = TagTranslations::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'status',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'slug',
        'status',
        'name',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * The languages that belong to the tag item.
     *
     * @return BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, TagTranslations::getTableName(), 'item_id');
    }

    /**
     * Get all of the articles that are assigned this tag.
     */
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    /**
     * Get all of the newspaper that are assigned this tag.
     */
    public function newspapers()
    {
        return $this->morphedByMany(Newspaper::class, 'taggable');
    }

    /**
     * Get all of the techs that are assigned this tag.
     */
    public function techs()
    {
        return $this->morphedByMany(Tech::class, 'taggable');
    }
    /**
     * Get translated title.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        if ($trans = $this->translate('name')) {
            return $trans;
        }
        return '';
    }
}
