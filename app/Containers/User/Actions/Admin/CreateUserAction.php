<?php

namespace App\Containers\User\Actions\Admin;

use App\Actions\BaseAction;
use App\Containers\User\Repositories\UserRepository;
use App\Containers\User\Services\UploadFileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateUserAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function repo(): mixed
    {
        return UserRepository::class;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function handle(array $data): bool
    {
        try {
            $user = DB::transaction(function () use ($data) {
                return $this->repo->create($data);
            });

            if (!$user) {
                return false;
            }

            if (!empty($data['avatar'])) {
                $uploadedAvatar = (new UploadFileService())->uploadAvatarProfile($user, $data['avatar']);

                $user->update([
                    'avatar' => $uploadedAvatar['path'],
                    'avatar_thumbnail' => $uploadedAvatar['thumbnail_path']
                ]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_CREATE_USER]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return false;
        }
    }
}
