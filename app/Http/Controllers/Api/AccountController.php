<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Request\Account\UpdateAccountRequest;
use App\Queries\User\UserQueries;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class AccountController
 * @package App\Http\Controllers\Api
 */
class AccountController extends Controller
{
    /** @var UserQueries */
    protected $queries;

    /** @var Request */
    protected $request;

    /**
     * AccountController constructor.
     * @param Request $request
     * @param UserQueries $queries
     */
    public function __construct(Request $request, UserQueries $queries)
    {
        $this->request = $request;
        $this->queries = $queries;
    }

    /**
     * Update Account User
     *
     * @param UpdateAccountRequest $updateAccountRequest
     * @param $userId
     * @throws ValidationException
     * @return array
     */
    public function updateUser(UpdateAccountRequest $updateAccountRequest, $userId): array
    {
        $userData = $this->validateRequest();
        $user = $this->queries->findUserById($userId);

        return [
            'message' => 'Account was changed successfully',
            'user' => $updateAccountRequest->execute($userData, $user),
        ];
    }

    /**
     * @throws ValidationException
     * @return array
     */
    private function validateRequest(): array
    {
        return $this->validate($this->request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email',
        ]);
    }
}
