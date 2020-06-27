<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * @package App\Models
 */
class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'job_title',
        'social_links',
        'short_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'social_links' => Json::class,
    ];
}
