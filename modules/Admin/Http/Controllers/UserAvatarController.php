<?php

namespace Modules\Admin\Http\Controllers;

use App\Containers\User\Actions\UploadAvatarAction;
use App\Containers\User\Data\DTOs\UploadAvatarDTO;
use App\Containers\User\Repositories\IUserRepository;
use App\Core\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * User Avatar Management Controller for Admin Module
 * 
 * Handles avatar upload, deletion, and management operations
 * for users in the admin interface.
 */
class UserAvatarController extends Controller
{
    /**
     * Constructor with dependency injection
     * 
     * @param UploadAvatarAction $uploadAvatarAction
     * @param FileUploadService $fileUploadService
     * @param IUserRepository $userRepository
     */
    public function __construct(
        private readonly UploadAvatarAction $uploadAvatarAction,
        private readonly FileUploadService $fileUploadService,
        private readonly IUserRepository $userRepository
    ) {}

    /**
     * Show upload avatar form for a specific user
     * 
     * @param int $userId
     * @return View
     */
    public function showUploadForm(int $userId): View
    {
        $user = $this->userRepository->findById($userId);
        
        if (!$user) {
            abort(404, 'User not found');
        }

        return view('admin::users.upload-avatar', compact('user'));
    }

    /**
     * Upload avatar for a specific user
     * 
     * @param Request $request
     * @param int $userId
     * @return RedirectResponse
     */
    public function upload(Request $request, int $userId): RedirectResponse
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

            return redirect()->route('admin.users.show', $userId)
                ->with('success', 'Avatar uploaded successfully');

        } catch (\InvalidArgumentException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while uploading avatar')
                ->withInput();
        }
    }

    /**
     * Delete avatar for a specific user
     * 
     * @param int $userId
     * @return RedirectResponse
     */
    public function delete(int $userId): RedirectResponse
    {
        try {
            $user = $this->userRepository->findById($userId);
            
            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            if (!$user->avatar) {
                return redirect()->back()->with('error', 'User has no avatar');
            }

            // Delete file
            $deleted = $this->fileUploadService->delete($user->avatar);

            if ($deleted) {
                // Update user
                $this->userRepository->update($userId, ['avatar' => null]);

                return redirect()->route('admin.users.show', $userId)
                    ->with('success', 'Avatar deleted successfully');
            }

            return redirect()->back()->with('error', 'Failed to delete avatar');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting avatar');
        }
    }
} 