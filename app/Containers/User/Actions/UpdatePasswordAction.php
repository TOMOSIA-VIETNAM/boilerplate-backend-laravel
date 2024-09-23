<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use Illuminate\Support\Facades\Log;

class UpdatePasswordAction
{
    /**
     * @param array $data
     * @return bool
     */
    public function handle(array $data): bool
    {
        try {
            /** @var User */
            $user = auth()->guard('api')->user();

            return $user->update($data);
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
