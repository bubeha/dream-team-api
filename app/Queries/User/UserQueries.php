<?php

declare(strict_types=1);

namespace App\Queries\User;

use App\Models\User;
use App\Services\QueryModifier\User\UserListQueryModifierContract;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserQueries
 * @package App\Queries\User
 */
interface UserQueries
{
    /**
     * @param int $size
     * @return mixed
     */
    public function getItemsWithPagination(int $size = 10);

    /**
     * @param $id
     * @return User
     */
    public function findById($id);

    /**
     * @param UserListQueryModifierContract $modifier
     * @return Collection|mixed
     */
    public function getList(UserListQueryModifierContract $modifier = null);
}
