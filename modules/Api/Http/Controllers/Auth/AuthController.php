<?php

namespace Modules\Api\Http\Controllers\Auth;

use App\Containers\User\Actions\Auth\LoginAction;
use App\Containers\User\Actions\Auth\RegisterAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\Api\Http\Controllers\ApiController;
use Modules\Api\Http\Requests\Auth\LoginRequest;
use Modules\Api\Http\Requests\Auth\RegisterRequest;
use Modules\Api\Transformers\SuccessResource;

class AuthController extends ApiController
{
    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return SuccessResource
     * @throws ValidationException
     */
    public function login(LoginRequest $request): SuccessResource
    {
        $response = resolve(LoginAction::class)->handle($request);

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
        $response =  resolve(RegisterAction::class)->handle($request->onlyFields());

        return SuccessResource::make($response);
    }
}
