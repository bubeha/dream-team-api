<?php

declare(strict_types=1);

namespace App\Services\Analise;

use App\Models\User;
use App\Queries\User\UserQueries;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

/**
 * Class Analise
 * @package App\Services\Analise
 */
class AnalyzeService
{
    /** @var UserQueries */
    private $queries;

    /**
     * AnaliseService constructor.
     * @param UserQueries $queries
     */
    public function __construct(UserQueries $queries)
    {
        $this->queries = $queries;
    }

    /**
     * @param array $userIds
     * @return array
     */
    public function analyzeUsers(array $userIds): array
    {
        $users = $this->queries
            ->getUsersForAnalise($userIds);

        $result = [];

        foreach ($users as $user) {
            /** @var User $user */
            $count = $user->reviews->count();

            $negative = $user->reviews->where('rating', '<', 0)->count();
            $neutral = $user->reviews->where('rating', '=', 0)->count();
            $positive = $user->reviews->where('rating', '>', 0)->count();

            $result[] = [
                'user' => $user,
                'statistic' => [
                    'negative' => calculatePercent($negative, $count),
                    'neutral' => calculatePercent($neutral, $count),
                    'positive' => calculatePercent($positive, $count),
                ],
            ];
        }

        return $result;
    }

    /**
     * @param Authenticatable $currentUser
     * @param array $authorIds
     * @param string $rating
     * @return Collection
     */
    public function analyzeCurrentUser(Authenticatable $currentUser, array $authorIds, string $rating): Collection
    {
        $user = $this->queries
            ->getUserWithReviews($currentUser->getAuthIdentifier(), $authorIds, $rating);

        return $user->reviews;
    }
}
