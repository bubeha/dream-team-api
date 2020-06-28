<?php

declare(strict_types=1);

namespace App\Services\QueryModifier\User;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserQueryModifierContract
 * @package App\Services\QueryModifier\User
 */
interface UserListQueryModifierContract
{
    /**
     * @param Builder $queries
     */
    public function search(Builder $queries): void;

    /**
     * @param Builder $queries
     */
    public function ignoreCurrentUser(Builder $queries): void;
}
