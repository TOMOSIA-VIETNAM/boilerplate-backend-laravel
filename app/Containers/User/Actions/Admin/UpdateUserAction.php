<?php

namespace App\Containers\User\Actions\Admin;

use App\Actions\BaseAction;
use App\Containers\User\Repositories\UserRepository;
use App\Containers\User\Services\UploadFileService;
use Illuminate\Support\Facades\Log;

class UpdateUserAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function repo(): mixed
    {
        return UserRepository::class;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function handle(int $id, array $data): bool
    {
        try {
            $user = $this->repo->findById($id);
            if (!$user) {
                return false;
            }

            if (!$data['password']) {
                unset($data['password']);
            }

            if (!empty($data['avatar'])) {
                $uploadedAvatar = (new UploadFileService())->uploadAvatarProfile($user, $data['avatar']);
                $data['avatar'] = $uploadedAvatar['path'];
                $data['avatar_thumbnail'] = $uploadedAvatar['thumbnail_path'];
            }

            $user->update($data);

            return true;
        } catch (\Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_UPDATE_USER]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return false;
        }
    }
}
