<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Data\DTOs\UploadAvatarDTO;
use App\Containers\User\Repositories\IUserRepository;
use App\Core\Services\FileUploadService;
use App\Containers\User\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class UploadAvatarAction
{
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly FileUploadService $fileUploadService
    ) {}

    public function execute(UploadAvatarDTO $dto): User
    {
        try {
            // Validate image
            if (!$this->fileUploadService->validateImage($dto->avatar)) {
                throw new \InvalidArgumentException('Invalid image file');
            }

            // Get user
            $user = $this->userRepository->findById($dto->userId);
            if (!$user) {
                throw new \InvalidArgumentException('User not found');
            }

            // Store old avatar path for cleanup
            $oldAvatarPath = $user->avatar;

            // Upload new avatar first
            $avatarPath = $this->fileUploadService->uploadAvatar($dto->avatar, $dto->userId);
            
            Log::info("New avatar uploaded successfully: {$avatarPath} for user {$dto->userId}");

            // Update user with new avatar path
            $updatedUser = $this->userRepository->updateById($dto->userId, ['avatar' => $avatarPath]);
            
            if (!$updatedUser) {
                // If update failed, delete the uploaded file
                $this->fileUploadService->delete($avatarPath);
                throw new \Exception('Failed to update user avatar');
            }

            // Delete old avatar after successful update
            if ($oldAvatarPath) {
                $deleted = $this->fileUploadService->delete($oldAvatarPath);
                
                if (!$deleted) {
                    Log::warning("Failed to delete old avatar: {$oldAvatarPath} for user {$dto->userId}");
                    // Don't throw exception here as the upload was successful
                } else {
                    Log::info("Old avatar deleted successfully: {$oldAvatarPath} for user {$dto->userId}");
                }
            }

            // Return updated user
            return $updatedUser;
            
        } catch (\Exception $e) {
            Log::error("Error in UploadAvatarAction for user {$dto->userId}: " . $e->getMessage());
            throw $e;
        }
    }
} 