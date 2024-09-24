<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use Illuminate\Support\Facades\Log;

class UpdatePasswordAction
{
    /**
     * @param string $password
     * @return bool
     */
    public function handle(string $password): bool
    {
        try {
            /** @var User */
            $user = auth()->guard('api')->user();

            return $user->update([
                'password' => $password
            ]);
        } catch (\Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_UPDATE_PASSWORD]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return false;
        }
    }
}
