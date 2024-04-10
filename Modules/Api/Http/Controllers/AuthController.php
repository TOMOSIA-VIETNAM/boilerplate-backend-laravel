<?php

namespace Modules\Api\Http\Controllers;

use Modules\Api\Contracts\Services\AuthService;
use Modules\Api\Http\Requests\AuthLoginRequest;
use Modules\Api\Repositories\Parameters\AuthLoginParam;
use Modules\Api\Transformers\AuthResource;
use App\Transformers\SuccessResource;

class AuthController extends BaseController
{
    /** @var AuthService */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * User login
     *
     * @OA\Post(
     *     path="/v1/login",
     *     tags={"AUTH"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthLoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResource"),
     *     )
     * )
     * @param AuthLoginRequest $request
     * @return AuthResource
     */
    public function login(AuthLoginRequest $request): AuthResource
    {
        $params = new AuthLoginParam($request->input('email'), $request->input('password'));
        $auth = $this->authService->login($params);

        return AuthResource::make($auth);
    }

    public function testAuth(): SuccessResource
    {
        return new SuccessResource();
    }
}
