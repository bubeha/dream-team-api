<?php

declare(strict_types=1);

namespace App\Services\Teams;

use App\Models\Team;
use Exception;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\DatabaseManager;
use Throwable;

/**
 * Class CreateTeamsService
 * @package App\Services\Teams
 */
class TeamsService
{
    /** @var ConnectionResolverInterface */
    private $dbManager;

    /**
     * CreateReviewService constructor.
     * @param DatabaseManager $manager
     */
    public function __construct(DatabaseManager $manager)
    {
        $this->dbManager = $manager;
    }

    /**
     * @param array $attributes
     * @param array $users
     * @return Team|null
     * @throws Throwable
     */
    public function createTeam(array $attributes, array $users): ?Team
    {
        $this->dbManager->beginTransaction();

        try {
            /** @var Team $team */
            $team = Team::query()->create($attributes);

            $team->users()->sync($users);

            $team->load('users');

            $this->dbManager->commit();

            return $team;
        } catch (Exception $exception) {
            $this->dbManager->rollBack();

            throw $exception;
        }
    }

    /**
     * @param Team $team
     * @param array $attributes
     * @param $users
     * @return Team|null
     * @throws Throwable
     */
    public function updateTeam(Team $team, array $attributes, $users): ?Team
    {
        $this->dbManager->beginTransaction();

        try {
            $team->update($attributes);
            $team->users()->sync($users);

            $team->load('users');

            $this->dbManager->commit();

            return $team;
        } catch (Exception $exception) {
            $this->dbManager->rollBack();

            throw $exception;
        }
    }
}
