<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Containers\User\Actions\GetUsersAction;
use App\Containers\User\Actions\CreateUserAction;
use App\Containers\User\Actions\UpdateUserAction;
use App\Containers\User\Actions\DeleteUserAction;
use App\Containers\User\Actions\GetUserByIdAction;
use App\Containers\User\Data\DTOs\CreateUserDTO;
use App\Containers\User\Data\DTOs\UpdateUserDTO;
use InvalidArgumentException;

/**
 * User Management Controller for Admin Module
 * 
 * Handles all user management operations including CRUD operations,
 * filtering, and user-specific queries for the admin interface.
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
     * Display a paginated list of users
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $filters = $request->all();
            $filters['paginate'] = true; // Always use pagination for admin
            
            $users = $this->getUsersAction->execute($filters);
            return view('admin::users.index', compact('users'));
        } catch (\Exception $e) {
            return view('admin::users.index')->with('error', 'Failed to retrieve users: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new user
     * 
     * @return View
     */
    public function create(): View
    {
        return view('admin::users.create');
    }

    /**
     * Store a newly created user in storage
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $user = $this->createUserAction->execute(
                CreateUserDTO::fromRequest($request)
            );
            return redirect()->route('admin.users.show', $user->id)
                ->with('success', 'User created successfully');
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified user
     * 
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        try {
            $user = $this->getUserByIdAction->execute($id);
            if (!$user) {
                return view('admin::users.show')->with('error', 'User not found');
            }
            return view('admin::users.show', compact('user'));
        } catch (\Exception $e) {
            return view('admin::users.show')->with('error', 'Failed to retrieve user: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified user
     * 
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        try {
            $user = $this->getUserByIdAction->execute($id);
            if (!$user) {
                return view('admin::users.edit')->with('error', 'User not found');
            }
            return view('admin::users.edit', compact('user'));
        } catch (\Exception $e) {
            return view('admin::users.edit')->with('error', 'Failed to retrieve user: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified user in storage
     * 
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $user = $this->updateUserAction->execute(
                $id,
                UpdateUserDTO::fromRequest($request)
            );
            if (!$user) {
                return back()->withInput()->withErrors(['error' => 'User not found']);
            }
            return redirect()->route('admin.users.show', $user->id)
                ->with('success', 'User updated successfully');
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified user from storage
     * 
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $deleted = $this->deleteUserAction->execute($id);
            if (!$deleted) {
                return back()->withErrors(['error' => 'User not found']);
            }
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete user: ' . $e->getMessage()]);
        }
    }

    /**
     * Get users filtered by role
     * 
     * @param string $role
     * @return View
     */
    public function getByRole(string $role): View
    {
        try {
            $users = $this->getUsersAction->execute(['role' => $role]);
            if ($users->isEmpty()) {
                return view('admin::users.index')->with('error', 'No users found with this role');
            }
            return view('admin::users.index', compact('users'));
        } catch (\Exception $e) {
            return view('admin::users.index')->with('error', 'Failed to retrieve users by role: ' . $e->getMessage());
        }
    }

    /**
     * Get users filtered by department
     * 
     * @param string $department
     * @return View
     */
    public function getByDepartment(string $department): View
    {
        try {
            $users = $this->getUsersAction->execute(['department' => $department]);
            if ($users->isEmpty()) {
                return view('admin::users.index')->with('error', 'No users found in this department');
            }
            return view('admin::users.index', compact('users'));
        } catch (\Exception $e) {
            return view('admin::users.index')->with('error', 'Failed to retrieve users by department: ' . $e->getMessage());
        }
    }

    /**
     * Get users with recent activities
     * 
     * @param Request $request
     * @return View
     */
    public function getWithRecentActivities(Request $request): View
    {
        try {
            $hours = $request->get('hours', 24);
            $users = $this->getUsersAction->execute(['recent_activities' => true, 'hours' => $hours]);
            if ($users->isEmpty()) {
                return view('admin::users.index')->with('error', 'No users found with recent activities');
            }
            return view('admin::users.index', compact('users'));
        } catch (\Exception $e) {
            return view('admin::users.index')->with('error', 'Failed to retrieve users with recent activities: ' . $e->getMessage());
        }
    }
} 