<?php

declare(strict_types=1);

namespace App\Models\Reviews;

use App\Events\ReviewChangesEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Review
 *
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $author_id
 * @property int $rating
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $author
 * @property-read array $attributes
 * @property-read Collection|Attribute[] $reviewAttributes
 * @property-read int|null $review_attributes_count
 * @property-read User $user
 * @method static Builder|Review newModelQuery()
 * @method static Builder|Review newQuery()
 * @method static Builder|Review query()
 * @method static Builder|Review whereAuthorId($value)
 * @method static Builder|Review whereCreatedAt($value)
 * @method static Builder|Review whereId($value)
 * @method static Builder|Review whereRating($value)
 * @method static Builder|Review whereUpdatedAt($value)
 * @method static Builder|Review whereUserId($value)
 * @uses \App\Models\Reviews\Review::getAttributesAttribute()
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
    public function getAttributesAttribute(): array
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
