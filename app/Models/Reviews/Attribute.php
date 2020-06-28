<?php

declare(strict_types=1);

namespace App\Models\Reviews;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 * @package App\Models\Reviews
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
