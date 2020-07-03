<?php

declare(strict_types=1);

namespace App\Models\Reviews;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Attribute
 *
 * @package App\Models\Reviews
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $review_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Attribute newModelQuery()
 * @method static Builder|Attribute newQuery()
 * @method static Builder|Attribute query()
 * @method static Builder|Attribute whereCreatedAt($value)
 * @method static Builder|Attribute whereId($value)
 * @method static Builder|Attribute whereName($value)
 * @method static Builder|Attribute whereReviewId($value)
 * @method static Builder|Attribute whereUpdatedAt($value)
 * @method static Builder|Attribute whereValue($value)
 */
class Attribute extends Model
{
    protected $table = 'review_attributes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
    ];
}
