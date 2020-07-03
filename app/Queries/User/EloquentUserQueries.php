<?php

declare(strict_types=1);

namespace App\Queries\User;

use App\Models\User;
use App\Services\QueryModifier\QueryModifierContract;
use App\Services\QueryModifier\User\UserListQueryModifierContract;
use Illuminate\Database\Eloquent\Builder;
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
    public function getItemsWithPagination(QueryModifierContract $modifier, int $size = 10)
    {
        $query = User::with('profile')
            ->select(
                'users.*',
                new Expression('p.job_title as job_title'),
                new Expression('p.focus as focus'),
                new Expression('p.rating as rating'),
                new Expression('CONCAT(first_name, \' \', last_name) as full_name')
            )
            ->join('profiles as p', 'p.user_id', '=', 'users.id');

        $modifier->modify($query);

        return $query->paginate($size);
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return User::query()
            ->with('profile')
            ->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getList(UserListQueryModifierContract $modifier = null)
    {
        $query = User::with('profile')
            ->select('id', new Expression('CONCAT(first_name, \' \', last_name) as name'));

        if ($modifier) {
            $modifier->modify($query);
        }

        return $query->get(['id', 'name'])
            ->pluck('name', 'id');
    }

    /**
     * @param array $users
     * @return mixed|void
     */
    public function getUsersForAnalise(array $users)
    {
        return User::query()
            ->with([
                'profile',
                'reviews' => static function ($query) use ($users) {
                    /** @var Builder $query */
                    $query
                        ->whereIn('author_id', $users)
                        ->whereIn('user_id', $users)
                        ->where('user_id', '!=', new Expression('author_id'))
                        ->groupBy('user_id', 'author_id')
                        ->orderBy('created_at', 'desc');
                },
            ])
            ->whereIn('id', $users)
            ->get();
    }

    /**
     * @param $currentUserId
     * @param array $authorIds
     * @param string $rating
     * @return mixed|void
     */
    public function getUserWithReviews($currentUserId, array $authorIds, string $rating)
    {
        return User::query()
            ->with([
                'reviews' => static function ($query) use ($rating, $currentUserId, $authorIds) {
                    $mapping = [
                        'neutral' => '=',
                        'positive' => '>',
                        'negative' => '<',
                    ];

                    /** @var Builder $query */
                    $query
                        ->with('author.profile')
                        ->whereIn('author_id', $authorIds)
                        ->where('user_id', '=', $currentUserId)
                        ->where('user_id', '!=', new Expression('author_id'))
                        ->groupBy('author_id')
                        ->orderBy('created_at', 'desc');

                    if (isset($mapping[$rating])) {
                        $query->where('rating', $mapping[$rating], 0);
                    }
                },
            ])
            ->findOrFail($currentUserId);
    }
}
