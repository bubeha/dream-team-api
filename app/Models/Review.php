<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * @package App\Models
 */
class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'strong_personal_characteristics',
        'weak_sides',
        'other_comments',
        'status',
    ];

    public const NEGATIVE_STATUS = 'negative';
    public const POSITIVE_STATUS = 'positive';
    public const NEUTRAL_STATUS = 'neutral';
}
