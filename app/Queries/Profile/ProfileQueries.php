<?php

declare(strict_types=1);

namespace App\Queries\Profile;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

/**
 * Interface ProfileQueries
 * @package App\Queries\Profile
 */
interface ProfileQueries
{
    /**
     * @param Authenticatable $currentUser
     * @return Collection
     */
    public function getUniqueJobs(Authenticatable $currentUser): Collection;

    /**
     * @param Authenticatable $currentUser
     * @return Collection
     */
    public function getUniqueFocuses(Authenticatable $currentUser): Collection;
}
