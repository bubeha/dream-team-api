<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Analise\AnalyzeService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

/**
 * Class AnaliseController
 * @package App\Http\Controllers\Api
 */
class AnalyzeController extends Controller
{
    /** @var ResponseFactory */
    private $response;

    /** @var Request */
    private $request;

    /** @var AnalyzeService */
    private $service;

    /**
     * AnaliseController constructor.
     * @param ResponseFactory $response
     * @param Request $request
     * @param AnalyzeService $service
     */
    public function __construct(ResponseFactory $response, Request $request, AnalyzeService $service)
    {
        $this->response = $response;
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getRelationshipStatistics(): JsonResponse
    {
        $attributes = $this->validate($this->request, $this->getValidationRules());

        return $this->response->json(
            $this->service->analyzeUsers($attributes['users'])
        );
    }

    /**
     * @param Authenticatable $currentUser
     * @return JsonResponse
     * @throws ValidationException
     */
    public function analyzeUser(Authenticatable $currentUser): JsonResponse
    {
        $attributes = $this->validate(
            $this->request,
            array_merge(
                $this->getValidationRules(),
                [
                    'rating' => [
                        'required',
                        'in:positive,negative,neutral',
                    ],
                ]
            )
        );

        return $this->response->json(
            $this->service->analyzeCurrentUser($currentUser, $attributes['users'], $attributes['rating'])
        );
    }

    /**
     * @return array
     */
    private function getValidationRules(): array
    {
        return [
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
