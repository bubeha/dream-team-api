<?php

declare(strict_types=1);

namespace App\Services\QueryModifier\User;

use App\Services\QueryModifier\QueryModifierContract;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserQueryModifierContract
 * @package App\Services\QueryModifier\User
 */
interface UserQueryModifierContract extends QueryModifierContract
{
    /**
     * @param Builder $queries
     */
    public function search(Builder $queries): void;

    /**
     * @param Builder $queries
     */
    public function ignoreCurrentUser(Builder $queries): void;

    /**
     * @param Builder $queries
     */
    public function filter(Builder $queries): void;

    /**
     * @param Builder $queries
     */
    public function sort(Builder $queries): void;
}
