<?php

declare(strict_types=1);

namespace App\Models\Reviews;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Review
 * @package App\Models
 */
class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'author_id',
        'rating',
    ];

    protected $with = ['reviewAttributes'];

    protected $appends = ['attributes'];

    protected $hidden = ['reviewAttributes'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @return HasMany
     */
    public function reviewAttributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * Attributes mutator
     *
     * @return array
     */
    public function getAttributesAttribute()
    {
        $attributes = [];

        if (isset($this->relations['reviewAttributes'])) {
            foreach ($this->relations['reviewAttributes'] as $attribute) {
                $attributes[$attribute['name']] = $attribute['value'];
            }
        }

        return $attributes;
    }
}
