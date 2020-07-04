<?php

declare(strict_types=1);

namespace App\Queries\Profile;

use App\Models\Profile;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

/**
 * Class EloquentProfileQueries
 * @package App\Queries\Profile
 */
class EloquentProfileQueries implements ProfileQueries
{

    /**
     * @inheritDoc
     */
    public function getUniqueJobs(Authenticatable $currentUser): Collection
    {
        return Profile::query()
            ->select('job_title')
            ->whereNotNull('job_title')
            ->where('user_id', '!=', $currentUser->getAuthIdentifier())
            ->distinct('job_title')
            ->pluck('job_title');
    }

    /**
     * @inheritDoc
     */
    public function getUniqueFocuses(Authenticatable $currentUser): Collection
    {
        return Profile::query()
            ->select('focus')
            ->whereNotNull('focus')
            ->where('user_id', '!=', $currentUser->getAuthIdentifier())
            ->distinct('focus')
            ->pluck('focus');
    }
}
