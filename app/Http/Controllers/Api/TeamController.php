<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Queries\Team\TeamQueries;
use App\Services\Teams\TeamsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;
use Throwable;

/**
 * Class TeamController
 * @package App\Http\Controllers\Api
 */
class TeamController extends Controller
{
    /** @var ResponseFactory */
    private $response;

    /** @var TeamQueries */
    private $queries;

    /**
     * TeamController constructor.
     * @param ResponseFactory $response
     * @param TeamQueries $queries
     */
    public function __construct(ResponseFactory $response, TeamQueries $queries)
    {
        $this->response = $response;
        $this->queries = $queries;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTeams(Request $request): JsonResponse
    {
        $result = $this->queries->getTeamsWithPagination($request->get('size', 10));

        return $this->response->json($result);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function showTeam($id): JsonResponse
    {
        $team = $this->queries->findOrFail($id);

        return $this->response->json($team);
    }

    /**
     * @param Request $request
     * @param TeamsService $service
     * @return JsonResponse
     * @throws ValidationException|Throwable
     */
    public function createTeam(Request $request, TeamsService $service): JsonResponse
    {
        $this->validate($request, $this->getValidationRules());

        $team = $service->createTeam(
            $request->except('users'),
            $request->get('users')
        );

        return $this->response->json($team);
    }

    /**
     * @param Request $request
     * @param TeamsService $service
     * @param $id
     * @return JsonResponse
     * @throws ValidationException|Throwable
     */
    public function updateTeam(Request $request, TeamsService $service, $id): JsonResponse
    {
        /** @var Team $team */
        $team = $this->queries->findOrFail($id);

        $this->validate($request, $this->getValidationRules($id));

        $team = $service->updateTeam(
            $team,
            $request->except('users'),
            $request->get('users')
        );

        return $this->response->json($team);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteTeam($id)
    {
        return Team::query()->where('id', '=', $id)
            ->delete();
    }

    /**
     * @param null $id
     * @return array
     */
    private function getValidationRules($id = null): array
    {
        $unique = Rule::unique('teams');

        if ($id) {
            $unique->ignore($id);
        }

        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                $unique,
            ],
            'users' => [
                'required',
                'array',
            ],
            'users.*' => [
                'required',
                'exists:users,id',
            ],
        ];
    }
}
