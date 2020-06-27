<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Queries\ReviewQueries;
use App\Services\QueryModifier\Feed\FeedQueryModifierContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Http\ResponseFactory;

/**
 * Class FeedController
 * @package App\Http\Controllers\Api
 */
class ReviewController extends Controller
{
    /**
     * @var ResponseFactory
     */
    private $response;
    /**
     * @var ReviewQueries
     */
    private $queries;

    /**
     * FeedController constructor.
     * @param ResponseFactory $response
     * @param ReviewQueries $queries
     */
    public function __construct(ResponseFactory $response, ReviewQueries $queries)
    {
        $this->response = $response;
        $this->queries = $queries;
    }

    /**
     * @param Authenticatable $currentUser
     * @param FeedQueryModifierContract $queryModifier
     * @param int $size
     * @return mixed
     */
    public function getFeedForEmployee(
        Authenticatable $currentUser,
        FeedQueryModifierContract $queryModifier,
        int $size = 10
    ) {
        $result = $this->queries
            ->getReviewsForEmployee(
                $currentUser->getAuthIdentifier(),
                $queryModifier,
                $size
            );

        return $this->response->json($result);
    }


    /**
     * @param Authenticatable $currentUser
     * @param $feedId
     * @return JsonResponse
     */
    public function show(Authenticatable $currentUser, $feedId): JsonResponse
    {
        $result = $this->queries->getByUserIdAndKey(
            $feedId,
            $currentUser->getAuthIdentifier()
        );

        return $this->response->json($result);
    }
}
