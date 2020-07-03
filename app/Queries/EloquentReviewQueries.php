<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Reviews\Review;
use App\Services\QueryModifier\Feed\FeedQueryModifierContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

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
            ->orderBy('created_at', 'desc')
            ->paginate($size);
    }

    /**
     * @inheritDoc
     */
    public function find($key)
    {
        return Review::with(['user.profile', 'author.profile'])
            ->findOrFail($key);
    }

    /**
     * @param $userId
     * @return Review|Builder|Model|object|null
     */
    public function getAVGRatingByUserId($userId)
    {
        return app('db')
            ->table('reviews')
            ->select(new Expression('AVG(rating) as rating'))
            ->where('user_id', '=', $userId)
            ->groupBy('user_id')
            ->first();
    }
}
