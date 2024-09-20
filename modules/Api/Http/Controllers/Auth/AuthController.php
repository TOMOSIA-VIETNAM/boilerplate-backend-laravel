<?php

namespace Modules\Api\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\Api\Http\Controllers\ApiController;
use Modules\Api\Http\Requests\Auth\LoginRequest;
use Modules\Api\Http\Requests\Auth\RegisterRequest;
use Modules\Api\Services\AuthService;
use Modules\Api\Transformers\SuccessResource;

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
     * @return SuccessResource
     * @throws ValidationException
     */
    public function login(LoginRequest $request): SuccessResource
    {
        $response = $this->service->login($request);

        return SuccessResource::make($response);
    }

    /**
     * Handle unauthentication request.
     *
     * @return SuccessResource
     */
    public function logout(): SuccessResource
    {
        Auth::guard('api')
            ->user()
            ->tokens()
            ->delete();

        return SuccessResource::make();
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param RegisterRequest $request
     * @return SuccessResource
     */
    public function register(RegisterRequest $request): SuccessResource
    {
        $response = $this->service->register($request->onlyFields());

        return SuccessResource::make($response);
    }
}
