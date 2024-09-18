<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Admin\Http\Requests\Permission\CreateRequest;
use Spatie\Permission\Models\Permission;

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
        Permission::create($request->onlyFields());

        return response()->json(['message' => 'Permission created successfully']);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->back();
    }

    /**
     * @param int $id
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function update(int $id, CreateRequest $request): JsonResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->onlyFields());

        return response()->json(['success' => true, 'message' => 'Permission updated successfully']);
    }
}
