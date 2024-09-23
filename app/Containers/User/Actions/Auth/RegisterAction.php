<?php

namespace App\Containers\User\Actions\Auth;

use App\Containers\User\Models\User;
use App\Containers\User\Repositories\UserRepository;
use App\Containers\User\Services\UploadFileService;
use App\Services\BaseService;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterAction extends BaseService
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
     * @return array|null
     */
    public function handle(array $data): array|null
    {
        try {
            $user = DB::transaction(function () use ($data) {
                return $this->repo->create($data);
            });

            if (!$user) {
                return null;
            }

            if (!empty($data['avatar'])) {
                $uploadedAvatar = (new UploadFileService())->uploadAvatarProfile($user, $data['avatar']);

                $user->update([
                    'avatar' => $uploadedAvatar['storage_path'],
                    'avatar_thumbnail' => $uploadedAvatar['thumbnail_path']
                ]);
            }

            return $this->createToken(user: $user);
        } catch (\Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_REGISTER_USER]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return null;
        }
    }

    /**
     * @param User|Authenticatable $user
     * @return array
     */
    protected function createToken(User|Authenticatable $user): array
    {
        $token = $user->createToken($user->email)->plainTextToken;

        return [
            'token' => $token,
            'type' => 'Bearer'
        ];
    }
}
