<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App\Models
 */
class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name'];

    public const MANAGER_ROLE = 'manager';
}
