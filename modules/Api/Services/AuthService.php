<?php

namespace Modules\Api\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Api\Http\Requests\Auth\LoginRequest;

class AuthService
{
    /**
     * Handle login request
     * 
     * @param LoginRequest $request
     * @return array
     * @throws ValidationException
     */
    public function login(LoginRequest $request): array
    {
        $request->authenticate();
        $user = Auth::guard('api')->user();
        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'message' => 'Login Success',
            'token' => $token,
            'type' => 'Bear'
        ];
    }
}
