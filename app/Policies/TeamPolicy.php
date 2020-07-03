<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;

/**
 * Class TeamPolicy
 * @package App\Policies
 */
class TeamPolicy
{
    /**
     * @param User $currentUser
     * @param Team $team
     * @return bool
     */
    public function show(User $currentUser, Team $team): bool
    {
        return $currentUser->hasRole(Role::MANAGER_ROLE) ||
            $team->users->where('id', '=', $currentUser->id)->count() > 0;
    }

    /**
     * @param User $currentUser
     * @return bool
     */
    public function list(User $currentUser): bool
    {
        return $currentUser->hasRole(Role::MANAGER_ROLE);
    }

    /**
     * @param User $currentUser
     * @return bool
     */
    public function create(User $currentUser): bool
    {
        return $currentUser->hasRole(Role::MANAGER_ROLE);
    }

    /**
     * @param User $currentUser
     * @return bool
     */
    public function update(User $currentUser): bool
    {
        return $currentUser->hasRole(Role::MANAGER_ROLE);
    }

    /**
     * @param User $currentUser
     * @return bool
     */
    public function delete(User $currentUser): bool
    {
        return $currentUser->hasRole(Role::MANAGER_ROLE);
    }
}
