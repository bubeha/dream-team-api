<?php

declare(strict_types=1);

namespace App\Services\Analise;

use App\Queries\User\UserQueries;

/**
 * Class Analise
 * @package App\Services\Analise
 */
class AnaliseService
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
    public function analiseUsers(array $userIds): array
    {
        $users = $this->queries
            ->getUsersForAnalise($userIds);

        $result = [];

        foreach ($users as $user) {
            $count = $user->reviews->count();

            if ($count > 0) {
                $result[] = [
                    'user' => $user,
                    'negative' => ($user->reviews->where('rating', '<', 0)->count() / $count) * 100,
                    'neutral' => ($user->reviews->where('rating', '=', 0)->count() / $count) * 100,
                    'positive' => ($user->reviews->where('rating', '>', 0)->count() / $count) * 100,
                ];
                continue;
            }

            $result[] = [
                'user' => $user,
                'negative' => 0,
                'neutral' => 0,
                'positive' => 0,
            ];
        }

        return $result;
    }
}
