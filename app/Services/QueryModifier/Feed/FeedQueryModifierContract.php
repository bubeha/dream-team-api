<?php

declare(strict_types=1);

namespace App\Services\QueryModifier\Feed;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ReviewFeedQueryModifier
 * @package App\Services
 */
interface FeedQueryModifierContract
{
    /**
     * @param Builder $queries
     */
    public function search(Builder $queries): void;

    /**
     * @param Builder $query
     */
    public function filterByStatus(Builder $query): void;
}
