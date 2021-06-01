<?php

namespace App\Models;

use App\Models\Traits\TableName;
use App\Models\Traits\TranslationTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tech extends Model
{
    protected $table = 'techs';

    use TranslationTable;

    /**
     * Disabled status
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
    protected $appends = ['title'];

    /**
     * Related model that stores translations for the model.
     *
     * @var string
     */
    protected $translatableModel = TechTranslations::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link',
        'status',
        'published_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'link',
        'title',
        'status',
        'published_at',
        'tags',
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
        return $this->belongsToMany(
            Language::class,
            TechTranslations::getTableName(),
            'item_id'
        );
    }

    /**
     * Get all of the tags for the post.
     * @return MorphToMany
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

}
