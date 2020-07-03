<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Queries\ReviewQueries;
use App\Queries\User\UserQueries;
use App\Services\QueryModifier\Feed\FeedQueryModifierContract;
use App\Services\Reviews\CreateReviewService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;
use Throwable;

/**
 * Class FeedController
 * @package App\Http\Controllers\Api
 */
class ReviewController extends Controller
{
    /** @var ResponseFactory */
    private $response;

    /** @var ReviewQueries */
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
     * @param FeedQueryModifierContract $modifier
     * @param int $size
     * @return mixed
     */
    public function getFeedForEmployee(
        Authenticatable $currentUser,
        FeedQueryModifierContract $modifier,
        int $size = 10
    ) {
        $result = $this->queries
            ->getReviewsForEmployee(
                $currentUser->getAuthIdentifier(),
                $modifier,
                $size
            );

        return $this->response
            ->json($result);
    }

    /**
     * @param $feedId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show($feedId): JsonResponse
    {
        $review = $this->queries->find($feedId);

        $this->authorize('show', $review);

        return $this->response
            ->json($review);
    }

    /**
     * @param $userId
     * @param UserQueries $userQueries
     * @param Request $request
     * @param CreateReviewService $service
     * @param Authenticatable $currentUser
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     * @throws Throwable
     */
    public function addNewReviewToUser(
        $userId,
        UserQueries $userQueries,
        Request $request,
        CreateReviewService $service,
        Authenticatable $currentUser
    ): JsonResponse {
        $user = $userQueries->findById($userId);

        /** @uses \App\Policies\UserPolicy::createReview() */
        $this->authorize('createReview', $user);

        $attributes = $this->validate(
            $request,
            $service->getValidationRules()
        );

        $review = $service->create($user, $currentUser, $attributes);

        return $this->response->json($review);
    }
}
