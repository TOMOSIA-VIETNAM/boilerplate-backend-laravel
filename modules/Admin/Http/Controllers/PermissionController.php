<?php

namespace Modules\Admin\Http\Controllers;

use App\Containers\RolePermission\Actions\CreatePermissionAction;
use App\Containers\RolePermission\Actions\DeletePermissionAction;
use App\Containers\RolePermission\Actions\UpdatePermissionAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Admin\Http\Requests\Permission\CreateRequest;

class PermissionController extends AdminController
{
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->middleware(['role:master_admin']);
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        resolve(CreatePermissionAction::class)->handle($request->get('name'));
        session()->flash('success', __('Permission created successfully'));

        return response()->json(['success' => true]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $deleted = resolve(DeletePermissionAction::class)->handle($id);

        if (!$deleted) {
            redirect()->back()->with('error', __('Delete failure'));
        }

        return redirect()->back()->with('success', __('Delete successfully'));
    }

    /**
     * @param int $id
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function update(int $id, CreateRequest $request): JsonResponse
    {
        $updated = resolve(UpdatePermissionAction::class)->handle($id, $request->get('name'));

        if (!$updated) {
            session()->flash('error', __('Permission updated failure'));
            return response()->json(['success' => false]);
        }

        session()->flash('success', __('Permission updated successfully'));
        return response()->json(['success' => true]);
    }
}
