<?php

namespace App\Models;

use App\Models\Traits\TableName;
use App\Models\Traits\TranslationTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Newspaper
 * @package App\Models
 * NewspaperTranslations $translationsAll
 */
class Newspaper extends Model
{
    use TableName, TranslationTable;

    /**
     * Status disabled
     */
    const STATUS_DRAFT = 0;

    /**
     * Active status
     */
    const STATUS_ACTIVE = 1;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['title','title_en', 'translations', 'mini_desc', 'content', 'technologies'];

    /**
     * Related model that stores translations for the model.
     *
     * @var string
     */
    protected $translatableModel = NewspaperTranslations::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file',
        'img',
        'status',
        'type',
        'published_at',
        'advantages',
        'questions',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'file',
        'img',
        'type',
        'status',
        'type',
        'published_at',
        'title_en',
        'title',
        'mini_desc',
        'technologies',
        'content',
        'created_at',
        'updated_at',
        'translations',
        'advantages',
        'questions',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * The languages that belong to the newspaper item.
     *
     * @return BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, NewspaperTranslations::getTableName(), 'item_id');
    }

    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get translated title.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        if ($trans = $this->translate('title')) {
            return $trans;
        }
        return '';
    }

    /**
     * Get translated title.
     *
     * @return string
     */
    public function getTitleEnAttribute()
    {
        if ($trans = $this->translate('title', null, null, 'en')) {
            return $trans;
        }
        return '';
    }

    /**
     * Get translated title.
     *
     * @return string
     */
    public function getMiniDescAttribute()
    {
        if ($trans = $this->translate('mini_desc')) {
            return $trans;
        }
        return '';
    }

    /**
     * Get translated title.
     *
     * @return string
     */
    public function getContentAttribute()
    {
        if ($trans = $this->translate('content')) {
            return $trans;
        }
        return '';
    }

    /**
     * Get translated title.
     *
     * @return string
     */
    public function getTechnologiesAttribute()
    {
        if ($trans = $this->translate('technologies')) {
            return $trans;
        }
        return '';
    }
}
