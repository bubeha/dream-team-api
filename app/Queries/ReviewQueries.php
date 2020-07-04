<?php

declare(strict_types=1);

namespace App\Queries;

use App\Services\QueryModifier\Feed\FeedQueryModifierContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @param $key
     * @return Builder|Builder[]|Collection|Model
     */
    public function find($key);

    /**
     * @param $userId
     * @return mixed
     */
    public function getAVGRatingByUserId($userId);
}
