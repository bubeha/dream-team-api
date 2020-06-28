<?php

declare(strict_types=1);

namespace App\Models\Reviews;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 *
 * @package App\Models\Reviews
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $review_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute whereReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews\Attribute whereValue($value)
 * @mixin \Eloquent
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
