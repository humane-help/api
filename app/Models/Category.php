<?php

namespace App\Models;

use App\Models\Traits\TableName;
use App\Models\Traits\TranslationTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Category
 *
 * @property int $id
 * @property string $slug
 * @property string $status
 * @property string $name
 * @property integer $ord
 * @property integer $parent_id
 * @property string $lang
 * @property array $translations
 * @package App\Models
 */
class Category extends Model
{
    use TableName, TranslationTable;

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
    protected $appends = [
        'name',
        'lang',
        'translations'
    ];

    /**
     * Related model that stores translations for the model.
     *
     * @var string
     */
    protected $translatableModel = CategoryTranslations::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'parent_id',
        'ord',
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
        'parent_id',
        'ord',
        'name',
        'title',
        'lang',
        'status',
        'translations',
    ];

    //protected $visible = ['name', 'slug', 'children'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * The languages that belong to the category item.
     *
     * @return BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, CategoryTranslations::getTableName(), 'item_id');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
