<?php

namespace Modules\Api\Http\Controllers;

use App\Containers\User\Actions\UploadAvatarAction;
use App\Containers\User\Data\DTOs\UploadAvatarDTO;
use App\Core\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * User Avatar Management Controller for API Module
 * 
 * Handles avatar upload and deletion operations via REST API endpoints.
 * Provides standardized JSON responses for avatar management operations.
 */
class UserAvatarController extends Controller
{
    /**
     * Constructor with dependency injection
     * 
     * @param UploadAvatarAction $uploadAvatarAction
     * @param FileUploadService $fileUploadService
     */
    public function __construct(
        private readonly UploadAvatarAction $uploadAvatarAction,
        private readonly FileUploadService $fileUploadService
    ) {}

    /**
     * Upload avatar for a specific user
     * 
     * @param Request $request
     * @param int $userId
     * @return JsonResponse
     */
    public function upload(Request $request, int $userId): JsonResponse
    {
        try {
            // Validate request
            $request->validate([
                'avatar' => $this->fileUploadService->getImageValidationRules()
            ]);

            // Create DTO
            $dto = UploadAvatarDTO::fromRequest($request, $userId);

            // Execute action
            $user = $this->uploadAvatarAction->execute($dto);

            return response()->json([
                'success' => true,
                'message' => 'Avatar uploaded successfully',
                'data' => [
                    'avatar_url' => $user->avatar_url
                ]
            ], 200);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading avatar'
            ], 500);
        }
    }

    /**
     * Delete avatar for a specific user
     * 
     * @param int $userId
     * @return JsonResponse
     */
    public function delete(int $userId): JsonResponse
    {
        try {
            // Get user
            $user = app(\App\Containers\User\Repositories\IUserRepository::class)->findById($userId);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if (!$user->avatar) {
                return response()->json([
                    'success' => false,
                    'message' => 'User has no avatar'
                ], 400);
            }

            // Delete file
            $deleted = $this->fileUploadService->delete($user->avatar);

            if ($deleted) {
                // Update user
                app(\App\Containers\User\Repositories\IUserRepository::class)->update($userId, ['avatar' => null]);

                return response()->json([
                    'success' => true,
                    'message' => 'Avatar deleted successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete avatar'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting avatar'
            ], 500);
        }
    }
} 