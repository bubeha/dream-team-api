<?php

declare(strict_types=1);

namespace App\Services\QueryModifier\User;

use App\Services\QueryModifier\QueryModifier;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ReviewFeedQueryModifier
 * @package App\Services
 */
class UserListQueryModifier extends QueryModifier implements UserListQueryModifierContract
{
    /**
     * @inheritDoc
     */
    public function search(Builder $queries): void
    {
        $queries->when($this->request->get('searchPhrase'), static function (Builder $query, $value) {
            $query->having('name', 'like', '%' . $value . '%');
        });
    }

    /**
     * @param Builder $queries
     */
    public function ignoreCurrentUser(Builder $queries): void
    {
        $user = $this->request->user();

        if ($user) {
            $queries->where('id', '!=', $user->getKey());
        }
    }

    /**
     * @inheritDoc
     */
    public function modify(Builder $query)
    {
        $this->search($query);
    }
}
