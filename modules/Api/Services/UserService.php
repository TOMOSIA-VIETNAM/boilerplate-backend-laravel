<?php

namespace Modules\Api\Services;

use App\Models\User;
use App\Shared\Storage\StorageClient;
use Modules\Api\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * @param UserRepository $userRepository
     * @param StorageClient $storageClient
     */
    public function __construct(protected UserRepository $userRepository, protected StorageClient $storageClient) {}

    /**
     * @param array $data
     * @return User|null
     */
    public function updateProfile(array $data): User|null
    {
        try {
            /** @var User */
            $user = auth()->guard('api')->user();

            if (!empty($data['avatar'])) {
                $uploadedAvatar = $this->handleAvatarUpload($user, $data['avatar']);
                $data['avatar'] = $uploadedAvatar['storage_path'];
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

    /**
     * @param array $data
     * @return bool
     */
    public function updatePassword(array $data): bool
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

    /**
     * Handle avatar upload and replacement.
     *
     * @param Model $user
     * @param UploadedFile $avatar
     * @return array|null
     */
    private function handleAvatarUpload(Model $user, UploadedFile $avatar): ?array
    {
        $folder = sprintf('users/%s', $user->id);
        $uploadedAvatar = $this->storageClient->upload($avatar, $folder);

        // Delete old avatar if exists
        if ($user->avatar) {
            $this->storageClient->deleteFile($user->avatar);
        }

        return $uploadedAvatar;
    }
}
