<?php

declare(strict_types=1);

namespace App\Queries\Profile;

use Illuminate\Support\Collection;

/**
 * Class ProfileQueries
 * @package App\Queries\Profile
 */
interface ProfileQueries
{
    /**
     * @return Collection
     */
    public function getUniqueJobs(): Collection;

    /**
     * @return Collection
     */
    public function getUniqueFocuses(): Collection;
}
