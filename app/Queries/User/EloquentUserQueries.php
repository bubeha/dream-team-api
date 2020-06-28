<?php

declare(strict_types=1);

namespace App\Queries\User;

use App\Models\User;

/**
 * Class EloquentUserQueries
 * @package App\Queries\User
 */
class EloquentUserQueries implements UserQueries
{

    /**
     * @inheritDoc
     */
    public function getListOfUsers(int $size = 10)
    {
        return User::with('profile')->paginate($size);
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return User::query()->findOrFail($id);
    }
}
