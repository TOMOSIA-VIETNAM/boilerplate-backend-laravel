<?php

namespace Modules\Api\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\Api\Http\Controllers\ApiController;
use Modules\Api\Http\Requests\Auth\LoginRequest;
use Modules\Api\Services\AuthService;

class AuthController extends ApiController
{
    /**
     * @param AuthService $service
     */
    public function __construct(protected AuthService $service)
    {
        //
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $response = $this->service->login($request);

        return $this->response(resource: $response, status: Response::HTTP_OK);
    }

    /**
     * Handle unauthentication request.
     * 
     * @return JsonResponse
     */
    public function logout(){
        Auth::guard('api')
            ->user()
            ->tokens()
            ->delete();

        return $this->response(status: Response::HTTP_OK);
    }
}
