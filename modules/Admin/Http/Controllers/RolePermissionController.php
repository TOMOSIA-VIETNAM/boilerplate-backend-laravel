<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends AdminController
{
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->middleware(['role:master_admin']);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $roles = Role::get();
        $permissions = Permission::get();

        return view('admin::role_permissions.index', compact('roles', 'permissions'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        foreach ($request->all()['permissions'] as $permissionName => $roles) {
            $permissionInstance = Permission::findByName($permissionName);
            if (!empty($permissionInstance)) {
                $permissionInstance->syncRoles(roles: $roles);
            }
        }

        return redirect()->back();
    }
}
