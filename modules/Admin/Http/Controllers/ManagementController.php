<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\Admin\CreateRequest;
use Modules\Admin\Http\Requests\Admin\UpdateRequest;
use Modules\Admin\Services\AdminService;
use Spatie\Permission\Models\Role;

class ManagementController extends AdminController
{
    /**
     * @param AdminService $adminService
     */
    public function __construct(protected AdminService $adminService)
    {
        $this->middleware(['role:master_admin'], ['except' => ['index']]);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $admins = $this->adminService->getLists();

        return view('admin::admins.index', compact('admins'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $roles = Role::get();

        return view('admin::admins.create', compact('roles'));
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $created = $this->adminService->create($request->onlyFields());

        if (!$created) {
            return redirect()->back()->with('error', value: __('Create failure'));
        }

        return redirect()->route('admin.management.index')->with('success', value: __('Create successfully'));
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $roles = Role::get();
        $admin = $this->adminService->findById($id);

        return view('admin::admins.edit', compact('admin', 'roles'));
    }

    /**
     * @param int $id
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateRequest $request): RedirectResponse
    {
        $updated = $this->adminService->updateById($id, $request->onlyFields()['role_user']);

        if (!$updated) {
            return redirect()->back()->with('error', value: __('Update failure'));
        }

        return redirect()->route('admin.management.index')->with('success', value: __('Update successfully'));
    }
}
