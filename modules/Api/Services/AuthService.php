<?php

namespace Modules\Api\Services;

use App\Models\User;
use App\Shared\Storage\StorageClient;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Api\Http\Requests\Auth\LoginRequest;
use Modules\Api\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * @param UserRepository $userRepository
     * @param StorageClient $storageClient
     */
    public function __construct(protected UserRepository $userRepository, protected StorageClient $storageClient) {}

    /**
     * Handle login request
     *
     * @param LoginRequest $request
     * @return array
     */
    public function login(LoginRequest $request): array
    {
        $request->authenticate();
        $user = Auth::guard('api')->user();

        return $this->createToken($user);
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function register(array $data): array|null
    {
        try {
            $user = DB::transaction(function () use ($data) {
                return $this->userRepository->create($data);
            });

            if (!$user) {
                return null;
            }

            if (!empty($data['avatar'])) {
                $uploadedAvatar = $this->handleAvatarUpload($user, $data['avatar']);

                $user->update([
                    'avatar' => $uploadedAvatar['storage_path'],
                    'avatar_thumbnail' => $uploadedAvatar['thumbnail_path']
                ]);
            }

            return $this->createToken($user);

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
     * Handle avatar upload and replacement.
     *
     * @param Model $user
     * @param UploadedFile $avatar
     * @return array|null
     */
    private function handleAvatarUpload(Model $user, UploadedFile $avatar): ?array
    {
        $folder = sprintf('users/%s', $user->id);
        $uploadedAvatar = $this->storageClient->upload($avatar, $folder, hasThumbnail: true);

        // Delete old avatar if exists
        if ($user->avatar) {
            $this->storageClient->deleteFile($user->avatar);
        }

        return $uploadedAvatar;
    }

    /**
     * @param User|Authenticatable $user
     * @return array
     */
    protected function createToken(User|Authenticatable $user): array
    {
        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'message' => 'Register Success',
            'token' => $token,
            'type' => 'Bear'
        ];
    }
}
