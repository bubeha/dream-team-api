<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Queries\EloquentReviewQueries;
use App\Queries\User\UserQueries;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getListOfUsers(): JsonResponse
    {
        $this->authorize('list', User::class);

        $result = $this->queries->getListOfUsers();

        return $this->response->json($result);
    }

    /**
     * @param EloquentReviewQueries $queries
     * @param $userId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getUserFeed(EloquentReviewQueries $queries, $userId): JsonResponse
    {
        $user = $this->queries->find($userId);
        $this->authorize('show', $user);

        $result = $queries->getReviewsForEmployee($user->getKey());

        return $this->response->json($result);
    }
}
