<?php

declare(strict_types=1);

namespace App\Services\QueryModifier;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface QueryModifierContract
 * @package App\Services\QueryModifier
 */
interface QueryModifierContract
{
    /**
     * @param Builder $query
     * @return mixed
     */
    public function modify(Builder $query);
}
