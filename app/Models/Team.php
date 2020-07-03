<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class TeamController
 * @package App\Models
 */
class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = ['name'];

    // relationships

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'teams_users');
    }
}
