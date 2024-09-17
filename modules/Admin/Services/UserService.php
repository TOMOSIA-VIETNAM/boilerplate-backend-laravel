<?php

namespace Modules\Admin\Services;

use App\Enums\PaginationEnum;
use App\Shared\Storage\StorageClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Repositories\UserRepository;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(protected UserRepository $userRepository, protected StorageClient $storageClient) {}

    /**
     * Summary of getLists
     * @return LengthAwarePaginator
     */
    public function getLists(): LengthAwarePaginator
    {
        return $this->userRepository
            ->orderBy('created_at', 'DESC')
            ->paginate(PaginationEnum::ADMIN_PAGINATE);
    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function deleteById(int $id): bool|null
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            return false;
        }

        if ($user->avatar) {
            $this->storageClient->deleteFile($user->avatar);
        }

        return $user->delete();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        try {
            $user = DB::transaction(function () use ($data) {
                return $this->userRepository->create($data);
            });

            if (!$user) {
                return false;
            }

            if (!empty($data['avatar'])) {
                $uploadedAvatar = $this->handleAvatarUpload($user, $data['avatar']);

                $user->update([
                    'avatar' => $uploadedAvatar['storage_path']
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

    /**
     * @param int $id
     * @return Model|null
     */
    public function findById(int $id): Model|null
    {
        return $this->userRepository->findById($id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateById(int $id, array $data): bool
    {
        try {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return false;
            }

            if (!$data['password']) {
                unset($data['password']);
            }

            if (!empty($data['avatar'])) {
                $uploadedAvatar = $this->handleAvatarUpload($user, $data['avatar']);
                $data['avatar'] = $uploadedAvatar['storage_path'];
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
