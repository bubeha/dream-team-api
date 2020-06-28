<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
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
     * @param $feedId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show($feedId): JsonResponse
    {
        $review = $this->queries->find($feedId);

        $this->authorize('show', $review);

        return $this->response->json($review);
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
     */
    public function addNewReviewToUser(
        $userId,
        UserQueries $userQueries,
        Request $request,
        CreateReviewService $service,
        Authenticatable $currentUser
    ): JsonResponse {
        /** @var User $user */
        $user = $userQueries->findUserById($userId);

        /** @uses \App\Policies\UserPolicy::createReview() */
        $this->authorize('createReview', $user);

        $data = $this->validate($request, $service->getValidationRules());

        $service->create($user, $currentUser, $data);

        return $this->response->json(true);
    }
}
