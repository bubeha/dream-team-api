<?php

declare(strict_types=1);

namespace App\Queries\Team;

use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class EloquentTeamQueries
 * @package App\Queries\Team
 */
class EloquentTeamQueries implements TeamQueries
{
    /**
     * @inheritDoc
     */
    public function getTeamsWithPagination(int $size = 10): LengthAwarePaginator
    {
        return Team::query()
            ->withCount('users')
            ->paginate($size);
    }

    /**
     * @inheritDoc
     */
    public function findOrFail($id)
    {
        return Team::query()
            ->with('users')
            ->findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function getAllTeams()
    {
        return Team::query()
            ->withCount('users')
            ->get();
    }
}
