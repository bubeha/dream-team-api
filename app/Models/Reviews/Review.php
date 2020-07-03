<?php

declare(strict_types=1);

namespace App\Models\Reviews;

use App\Events\ReviewChangesEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Review
 *
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $author_id
 * @property int $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read array $attributes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reviews\Attribute[] $reviewAttributes
 * @property-read int|null $review_attributes_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Review whereUserId($value)
 * @mixin \Eloquent
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
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => ReviewChangesEvent::class,
        'deleted' => ReviewChangesEvent::class,
    ];

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
