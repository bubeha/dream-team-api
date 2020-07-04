<?php

declare(strict_types=1);

namespace App\Queries\Team;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface TeamQueries
 * @package App\Queries\Team
 */
interface TeamQueries
{
    /**
     * @param int $size
     * @return LengthAwarePaginator
     */
    public function getTeamsWithPagination(int $size = 10): LengthAwarePaginator;

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findOrFail($id);
}
