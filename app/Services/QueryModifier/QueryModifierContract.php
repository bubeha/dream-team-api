<?php

declare(strict_types=1);

namespace App\Services\QueryModifier;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class QueryModifierContract
 * @package App\Services
 */
interface QueryModifierContract
{
    /**
     * @param Builder $query
     * @return mixed
     */
    public function modify(Builder $query);
}
