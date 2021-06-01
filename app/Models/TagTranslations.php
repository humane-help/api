<?php

namespace App\Models;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TagTranslations
 * @package App\Models
 */
class TagTranslations extends Model
{
    use TableName;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['short_name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the content item that owns the translation.
     *
     * @return BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * Get the language that owns the translation.
     *
     * @return BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the language that owns the translation.
     *
     * @return BelongsTo
     */
    public function getShortNameAttribute()
    {
        return Language::find($this->language_id)->short_name;
    }
}
