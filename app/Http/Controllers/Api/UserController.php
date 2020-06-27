<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Http\ResponseFactory;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * @var ResponseFactory
     */
    private $response;

    /**
     * UserController constructor.
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * @param Authenticatable $currentUser
     * @return JsonResponse
     */
    public function __invoke(Authenticatable $currentUser)
    {
        if ($currentUser instanceof User) {
            $currentUser->loadMissing(['roles', 'profile']);
        }

        return $this->response->json($currentUser);
    }
}
