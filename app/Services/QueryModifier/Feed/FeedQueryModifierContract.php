<?php

declare(strict_types=1);

namespace App\Services\QueryModifier\Feed;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface FeedQueryModifierContract
 * @package App\Services\QueryModifier\Feed
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
    public function filterByRating(Builder $query): void;
}
