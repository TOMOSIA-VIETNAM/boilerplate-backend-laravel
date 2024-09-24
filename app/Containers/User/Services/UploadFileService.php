<?php

namespace App\Containers\User\Services;

use App\Shared\Storage\StorageClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class UploadFileService
{
    /**
     * Handle avatar upload and replacement.
     *
     * @param Model $user
     * @param UploadedFile $avatar
     * @return array|null
     */
    public function uploadAvatarProfile(Model $user, UploadedFile $avatar): ?array
    {
        $storageClient = new StorageClient();

        $folder = sprintf('users/%s', $user->id);
        $dataAvatar = $storageClient->upload($avatar, $folder, hasThumbnail: true);

        // if old avatar exists then remove it
        if ($user->avatar) {
            $storageClient->deleteImage($user->avatar);
        }

        // if old avatar thumbnail exists then remove it
        if ($user->avatar_thumbnail) {
            $storageClient->deleteImage($user->avatar_thumbnail);
        }

        return $dataAvatar;
    }
}
