<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Review;
use App\Models\Role;
use App\Models\User;

/**
 * Class ReviewPolicy
 * @package App\Policies
 */
class ReviewPolicy
{
    /**
     * @param User $user
     * @param Review $review
     * @return bool
     */
    public function show(User $user, Review $review): bool
    {
        return $user->hasRole(Role::MANAGER_ROLE) || $review->user_id === $user->id;
    }
}
