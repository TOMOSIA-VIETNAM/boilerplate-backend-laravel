<?php

namespace App\Containers\User\Actions\Admin;

use App\Actions\BaseAction;
use App\Containers\User\Repositories\UserRepository;
use App\Shared\Storage\StorageClient;

class DeleteUserAction extends BaseAction
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
     * @return bool
     */
    public function handle(int $id): bool
    {
        $user = $this->repo->findById($id);

        if ($user->avatar) {
            resolve(StorageClient::class)->deleteImage($user->avatar);
        }

        if ($user->avatar_thumbnail) {
            resolve(StorageClient::class)->deleteImage($user->avatar_thumbnail);
        }

        return $user->delete();
    }
}
