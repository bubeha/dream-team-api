<?php

declare(strict_types=1);

namespace App\Queries\Profile;

use App\Models\Profile;
use Illuminate\Support\Collection;

/**
 * Class EloquentProfileQueries
 * @package App\Queries\Profile
 */
class EloquentProfileQueries implements ProfileQueries
{

    /**
     * @return Collection
     */
    public function getUniqueJobs(): Collection
    {
        return Profile::query()
            ->select('id', 'job_title')
            ->whereNotNull('job_title')
            ->distinct('job_title')
            ->pluck('job_title', 'id');
    }

    /**
     * @return Collection
     */
    public function getUniqueFocuses(): Collection
    {
        return Profile::query()
            ->select('id', 'focus')
            ->whereNotNull('focus')
            ->distinct('focus')
            ->pluck('focus', 'id');
    }
}
