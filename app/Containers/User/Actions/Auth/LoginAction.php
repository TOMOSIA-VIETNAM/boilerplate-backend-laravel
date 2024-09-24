<?php

namespace App\Containers\User\Actions\Auth;

use App\Containers\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\Api\Http\Requests\Auth\LoginRequest;

class LoginAction
{
    /**
     * @param LoginRequest $request
     * @return array
     */
    public function handle(LoginRequest $request): array
    {
        $request->authenticate();

        /** @var User */
        $user = Auth::guard('api')->user();

        $token =$user->createToken($user->email)->plainTextToken;

        return [
            'token' => $token,
            'type' => 'Bearer'
        ];
    }
}
