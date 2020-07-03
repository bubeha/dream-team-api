<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Queries\Team\TeamQueries;
use App\Services\Teams\TeamsService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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
     * @throws AuthorizationException
     */
    public function getTeams(Request $request): JsonResponse
    {
        $this->authorize('list', Team::class);

        $result = $this->queries->getTeamsWithPagination($request->get('size', 10));

        return $this->response->json($result);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function showTeam($id): JsonResponse
    {
        $team = $this->queries->findOrFail($id);

        $this->authorize('show', $team);

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
        $this->authorize('create', Team::class);

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
        $this->authorize('update', Team::class);

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
     * @throws AuthorizationException
     * @throws Exception
     */
    public function deleteTeam($id)
    {
        $this->authorize('delete', Team::class);

        $team = $this->queries->findOrFail($id);

        return $team->delete();
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
