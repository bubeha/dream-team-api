<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Review;
use App\Services\QueryModifier\Feed\FeedQueryModifierContract;

/**
 * Class EloquentReviewQueries
 * @package App\Queries
 */
class EloquentReviewQueries implements ReviewQueries
{
    /**
     * @inheritDoc
     */
    public function getReviewsForEmployee($userId, FeedQueryModifierContract $queryModifier = null, int $size = 10)
    {
        $query = Review::query()
            ->with(['user.profile', 'author.profile'])
            ->where('user_id', '=', $userId);

        if ($queryModifier) {
            $queryModifier->modify($query);
        }

        return $query
            ->paginate($size);
    }

    /**
     * @inheritDoc
     */
    public function getByUserIdAndKey($key, $userId)
    {
        return Review::with(['user.profile', 'author.profile'])
            ->where('user_id', '=', $userId)
            ->findOrFail($key);
    }
}
