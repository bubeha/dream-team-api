<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Queries\EloquentReviewQueries;
use App\Queries\Profile\ProfileQueries;
use App\Queries\User\UserQueries;
use App\Services\QueryModifier\User\UserListQueryModifierContract;
use App\Services\QueryModifier\User\UserQueryModifierContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Http\Request;
use Laravel\Lumen\Http\ResponseFactory;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /** @var ResponseFactory */
    private $response;

    /** @var UserQueries */
    private $queries;

    /**
     * UserController constructor.
     * @param ResponseFactory $response
     * @param UserQueries $queries
     */
    public function __construct(ResponseFactory $response, UserQueries $queries)
    {
        $this->response = $response;
        $this->queries = $queries;
    }

    /**
     * @param UserQueryModifierContract $modifier
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getUsersWithPagination(UserQueryModifierContract $modifier, Request $request): JsonResponse
    {
        $this->authorize('list', User::class);

        return $this->response
            ->json(
                $this->queries->getItemsWithPagination($modifier, $request->get('size', 10))
            );
    }

    /**
     * @param EloquentReviewQueries $queries
     * @param $userId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getUserFeed(EloquentReviewQueries $queries, $userId): JsonResponse
    {
        $user = $this->queries
            ->findById($userId);

        $this->authorize('show', $user);

        return $this->response
            ->json(
                $queries->getReviewsForEmployee($user->getKey())
            );
    }

    /**
     * @param UserListQueryModifierContract $modifier
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getListOfUsers(UserListQueryModifierContract $modifier): JsonResponse
    {
        $this->authorize('list', User::class);

        return $this->response
            ->json(
                $this->queries->getList($modifier)
            );
    }

    /**
     * @param ProfileQueries $profileQueries
     * @param Authenticatable $currentUser
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getDataForFilter(ProfileQueries $profileQueries, Authenticatable $currentUser): JsonResponse
    {
        $this->authorize('list', User::class);

        return $this->response
            ->json([
                'focuses' => $profileQueries->getUniqueFocuses($currentUser),
                'jobs' => $profileQueries->getUniqueJobs($currentUser),
            ]);
    }

    /**
     * @param $userId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getUser($userId): JsonResponse
    {
        $user = $this->queries->findById($userId);

        $this->authorize('show', $user);

        return $this->response
            ->json($user);
    }
}
