<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\App\Http\Requests\LoginRequest;
use Modules\Auth\App\Http\Requests\RegisterRequest;
use Modules\Auth\App\Http\Services\AuthServices;
use Modules\Users\App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends MainController
{
    private $authService;

    public function __construct(AuthServices $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     * @param RegisterRequest $request
     * @OA\Post(
     *  path="/api/v1/auth/register",
     *  summary="Register a new user",
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *      @OA\JsonContent(ref="Modules\Auth\App\Http\Requests\RegisterRequest")
     *  ),
     *  @OA\Response(response=201, description="success")
     * )
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $request = $request->validated();
        $response = $this->authService->register($request);
        return $this->response('success' , new UserResource($response), Response::HTTP_CREATED);
    }

    /**
     * Login a user.
     * @param LoginRequest $request
     * @OA\Post(
     *  path="/api/v1/auth/login",
     *  summary="Login a user",
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *      @OA\JsonContent(ref="Modules\Auth\App\Http\Requests\LoginRequest")
     *  ),
     *  @OA\Response(response=200, description="success")
     * )
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request = $request->validated();
        $response = $this->authService->login($request);
        return $this->response('success', $response, Response::HTTP_OK);
    }
}
