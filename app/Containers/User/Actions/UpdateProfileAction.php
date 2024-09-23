<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use App\Containers\User\Services\UploadFileService;
use Illuminate\Support\Facades\Log;

class UpdateProfileAction
{
    /**
     * @param array $data
     * @return User|null
     */
    public function handle(array $data): User|null
    {
        try {
            /** @var User */
            $user = auth()->guard('api')->user();

            if (!empty($data['avatar'])) {
                $uploadedAvatar = (new UploadFileService())->uploadAvatarProfile($user, $data['avatar']);
                $data['avatar'] = $uploadedAvatar['storage_path'];
                $data['avatar_thumbnail'] = $uploadedAvatar['thumbnail_path'];
            }

            $user->update($data);

            return $user;
        } catch (\Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_UPDATE_USER]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return null;
        }
    }
}
