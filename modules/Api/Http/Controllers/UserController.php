<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Containers\User\Actions\GetUsersAction;
use App\Containers\User\Actions\CreateUserAction;
use App\Containers\User\Actions\UpdateUserAction;
use App\Containers\User\Actions\DeleteUserAction;
use App\Containers\User\Actions\GetUserByIdAction;
use App\Containers\User\Data\DTOs\CreateUserDTO;
use App\Containers\User\Data\DTOs\UpdateUserDTO;
use Modules\Api\Transforms\UserTransform;
use InvalidArgumentException;

/**
 * User Management Controller for API Module
 * 
 * Handles all user management operations via REST API endpoints.
 * Provides CRUD operations, filtering, and user-specific queries
 * with standardized JSON responses.
 */
class UserController extends Controller
{
    /**
     * Constructor with dependency injection
     * 
     * @param GetUsersAction $getUsersAction
     * @param CreateUserAction $createUserAction
     * @param UpdateUserAction $updateUserAction
     * @param DeleteUserAction $deleteUserAction
     * @param GetUserByIdAction $getUserByIdAction
     */
    public function __construct(
        private readonly GetUsersAction $getUsersAction,
        private readonly CreateUserAction $createUserAction,
        private readonly UpdateUserAction $updateUserAction,
        private readonly DeleteUserAction $deleteUserAction,
        private readonly GetUserByIdAction $getUserByIdAction
    ) {}

    /**
     * Get paginated list of users
     * 
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get list of users",
     *     @OA\Response(response="200", description="Success")
     * )
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->all();
            $filters['paginate'] = true; // Always use pagination for API
            
            $users = $this->getUsersAction->execute($filters);
            return response()->json(UserTransform::collection($users));
        } catch (\Exception $e) {
            return response()->json(
                UserTransform::error('Failed to retrieve users', $e->getMessage()),
                500
            );
        }
    }

    /**
     * Create a new user
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $user = $this->createUserAction->execute(
                CreateUserDTO::fromRequest($request)
            );
            return response()->json(
                UserTransform::single($user, 'User created successfully'),
                201
            );
        } catch (InvalidArgumentException $e) {
            return response()->json(
                UserTransform::error('Validation failed', $e->getMessage()),
                422
            );
        } catch (\Exception $e) {
            return response()->json(
                UserTransform::error('Failed to create user', $e->getMessage()),
                500
            );
        }
    }

    /**
     * Get a specific user by ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->getUserByIdAction->execute($id);
            if (!$user) {
                return response()->json(
                    UserTransform::error('User not found'),
                    404
                );
            }
            return response()->json(UserTransform::single($user));
        } catch (\Exception $e) {
            return response()->json(
                UserTransform::error('Failed to retrieve user', $e->getMessage()),
                500
            );
        }
    }

    /**
     * Update a specific user
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $user = $this->updateUserAction->execute(
                $id,
                UpdateUserDTO::fromRequest($request)
            );
            if (!$user) {
                return response()->json(
                    UserTransform::error('User not found'),
                    404
                );
            }
            return response()->json(
                UserTransform::single($user, 'User updated successfully')
            );
        } catch (InvalidArgumentException $e) {
            return response()->json(
                UserTransform::error('Validation failed', $e->getMessage()),
                422
            );
        } catch (\Exception $e) {
            return response()->json(
                UserTransform::error('Failed to update user', $e->getMessage()),
                500
            );
        }
    }

    /**
     * Delete a specific user
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->deleteUserAction->execute($id);
            if (!$deleted) {
                return response()->json(
                    UserTransform::error('User not found'),
                    404
                );
            }
            return response()->json(
                UserTransform::success('User deleted successfully')
            );
        } catch (\Exception $e) {
            return response()->json(
                UserTransform::error('Failed to delete user', $e->getMessage()),
                500
            );
        }
    }

    /**
     * Get users filtered by role
     * 
     * @param string $role
     * @return JsonResponse
     */
    public function getByRole(string $role): JsonResponse
    {
        try {
            $users = $this->getUsersAction->execute(['role' => $role]);
            if ($users->isEmpty()) {
                return response()->json(
                    UserTransform::error('No users found with this role'),
                    404
                );
            }
            return response()->json(UserTransform::collection($users));
        } catch (\Exception $e) {
            return response()->json(
                UserTransform::error('Failed to retrieve users by role', $e->getMessage()),
                500
            );
        }
    }

    /**
     * Get users filtered by department
     * 
     * @param string $department
     * @return JsonResponse
     */
    public function getByDepartment(string $department): JsonResponse
    {
        try {
            $users = $this->getUsersAction->execute(['department' => $department]);
            if ($users->isEmpty()) {
                return response()->json(
                    UserTransform::error('No users found in this department'),
                    404
                );
            }
            return response()->json(UserTransform::collection($users));
        } catch (\Exception $e) {
            return response()->json(
                UserTransform::error('Failed to retrieve users by department', $e->getMessage()),
                500
            );
        }
    }

    /**
     * Get users with recent activities
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getWithRecentActivities(Request $request): JsonResponse
    {
        try {
            $hours = $request->get('hours', 24);
            $users = $this->getUsersAction->execute(['recent_activities' => true, 'hours' => $hours]);
            if ($users->isEmpty()) {
                return response()->json(
                    UserTransform::error('No users found with recent activities'),
                    404
                );
            }
            return response()->json(UserTransform::collection($users));
        } catch (\Exception $e) {
            return response()->json(
                UserTransform::error('Failed to retrieve users with recent activities', $e->getMessage()),
                500
            );
        }
    }
} 