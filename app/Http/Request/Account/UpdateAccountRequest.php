<?php

declare(strict_types = 1);

namespace App\Http\Request\Account;

use App\Models\User;

/**
 * Class UpdateAccountRequest
 * @package App\Http\Request\Account
 */
class UpdateAccountRequest
{
    /**
     * @param $userData
     * @param User $user
     * @return User
     */
    public function execute($userData, User $user)
    {
        $user->update($userData);

        return $user;
    }
}
