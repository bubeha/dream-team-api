<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Analise\AnaliseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

/**
 * Class AnaliseController
 * @package App\Http\Controllers\Api
 */
class AnaliseController extends Controller
{
    /** @var ResponseFactory */
    private $response;

    /**
     * AnaliseController constructor.
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * @param Request $request
     * @param AnaliseService $service
     * @return JsonResponse
     * @throws ValidationException
     */
    public function usersAnalise(Request $request, AnaliseService $service): JsonResponse
    {
        $attributes = $this->validate($request, $this->getValidationRules());

        return $this->response->json(
            $service->analiseUsers($attributes['users'])
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
