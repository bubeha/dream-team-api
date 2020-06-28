<?php

declare(strict_types=1);

namespace App\Queries\User;

use App\Services\QueryModifier\QueryModifierContract;
use App\Services\QueryModifier\User\UserListQueryModifierContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
    public function getUsersWithPagination(int $size = 10);

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function findUserById($id);

    /**
     * @param UserListQueryModifierContract $modifier
     * @return Collection|mixed
     */
    public function getListOfUsers(UserListQueryModifierContract $modifier = null);
}
