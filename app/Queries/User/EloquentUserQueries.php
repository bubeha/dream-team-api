<?php

declare(strict_types=1);

namespace App\Queries\User;

use App\Models\User;
use App\Services\QueryModifier\User\UserListQueryModifierContract;
use Illuminate\Database\Query\Expression;

/**
 * Class EloquentUserQueries
 * @package App\Queries\User
 */
class EloquentUserQueries implements UserQueries
{

    /**
     * @inheritDoc
     */
    public function getUsersWithPagination(int $size = 10)
    {
        return User::with('profile')->paginate($size);
    }

    /**
     * @inheritDoc
     */
    public function findUserById($id)
    {
        return User::query()
            ->with('profile')
            ->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getListOfUsers(UserListQueryModifierContract $modifier = null)
    {
        $query = User::with('profile')
            ->select('id', new Expression('CONCAT(first_name, \' \', last_name) as name'));

        if ($modifier) {
            $modifier->modify($query);
        }

        return $query->get(['id', 'name'])
            ->pluck('name', 'id');
    }
}
