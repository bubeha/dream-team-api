<?php

declare(strict_types=1);

namespace App\Queries;

use App\Services\QueryModifier\Feed\FeedQueryModifierContract;

/**
 * Interface ReviewQueries
 * @package App\Queries
 */
interface ReviewQueries
{

    /**
     * @param $userId
     * @param FeedQueryModifierContract $queryModifier
     * @param int $size
     * @return mixed
     */
    public function getReviewsForEmployee($userId, FeedQueryModifierContract $queryModifier = null, int $size = 10);
}
