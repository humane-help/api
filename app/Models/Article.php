<?php

namespace App\Models;

use App\Models\Traits\TableName;
use App\Models\Traits\TranslationTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Article
 *
 * @property int $id
 * @property string $slug
 * @property int $status
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $img
 * @property string $url
 * @property string $author
 * @property string $category_name
 * @property string $category_slug
 * @property string $lang
 * @property string $published_at
 * @property bool $is_main
 * @property int $category_id
 * @property Category $category
 * @property Language $languages
 * @property Tag $tags
 * @property array $translations
 * @property ArticleTranslations $translationsAll
 * @package App\Models
 */
class Article extends Model
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
     * The accessors to append to the model's array form..
     *
     * @var array
     */
    protected $appends = [
        'title',
        'description',
        'content',
        'url',
        'category_name',
        'category_slug',
        'lang',
        'translations'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'title',
        'description',
        'url',
        'category_name',
        'category_slug',
        'published_at',
        'slug',
        'author',
        'published_at',
        'img',
        'is_main',
        'tags',
    ];

    /**
     * Related model that stores translations for the model.
     *
     * @var string
     */
    protected $translatableModel = ArticleTranslations::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'author',
        'published_at',
        'img',
        'category_id',
        'status',
        'is_main',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return mixed
     */
    public function getTagIdsAttribute()
    {
        return $this->tags->pluck('id');
    }

    /**
     * The languages that belong to the article item.
     *
     * @return BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, ArticleTranslations::getTableName(), 'item_id');
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
     * Get translated description.
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        if ($trans = $this->translate('description')) {
            return $trans;
        }
        return '';
    }

    /**
     * Get translated content.
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
     * Get translated source.
     *
     * @return string
     */
    public function getSourceAttribute()
    {
        if ($trans = $this->translate('source')) {
            return $trans;
        }
        return '';
    }

    /**
     * Get the category.
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the url.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        $categorySlug = ($this && $this->category && $this->category->slug)
            ? $this->category->slug
            : '';
        $articleSlug = ($this && $this->slug) ? $this->slug : '';
        return "/categories/" . $categorySlug . '/' . $articleSlug;
    }

    /**
     * Get category name.
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return isset($this->category->name) ? $this->category->name : null;
    }

    /**
     * Get category slug
     *
     * @return string
     */
    public function getCategorySlugAttribute()
    {
        return isset($this->category->slug) ? $this->category->slug : null;
    }

    /**
     * Scope active articles
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', '=', self::STATUS_ACTIVE);
    }
}
