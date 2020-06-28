<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /** @var Request */
    private $request;

    /** @var ResponseFactory */
    private $response;

    /** @var Guard|StatefulGuard */
    private $guard;

    /**
     * LoginController constructor.
     * @param Request $request
     * @param ResponseFactory $response
     * @param Factory $factory
     */
    public function __construct(Request $request, ResponseFactory $response, Factory $factory)
    {
        $this->request = $request;
        $this->response = $response;
        $this->guard = $factory->guard('api');
    }

    /**
     * @throws ValidationException
     */
    public function login(): JsonResponse
    {
        $credentials = $this->validateRequest();
        $token = $this->guard->attempt($credentials);

        if (! $token) {
            return $this->response
                ->json(['error' => 'Invalid credentials'], 401);
        }

        $user = $this->guard->user();

        if ($user instanceof User) {
            $user->loadMissing(['profile', 'roles']);
        }

        return $this->response
            ->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => $this->guard->factory()->getTTL() * 60,
                'user' => $user,
            ]);
    }

    /**
     * @return Authenticatable
     */
    public function getCurrentUserData(): Authenticatable
    {
        return $this->guard->user();
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->guard->logout();

        return $this->response
            ->json([
                'message' => 'Successfully logged out',
            ]);
    }

    /**
     * @throws ValidationException
     */
    private function validateRequest(): array
    {
        return $this->validate($this->request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8',
        ]);
    }
}
