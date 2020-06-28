<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

/**
 * Class UserPolicies
 * @package App\Policies
 */
class UserPolicy
{
    /**
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function show(User $currentUser, User $user): bool
    {
        return $currentUser->hasRole(Role::MANAGER_ROLE) || $currentUser->id === $user->id;
    }

    /**
     * @param User $currentUser
     * @return bool
     */
    public function list(User $currentUser): bool
    {
        return (bool)$currentUser;
    }

    /**
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function createReview(User $currentUser, User $user): bool
    {
        return $user->id !== $currentUser->id;
    }
}
