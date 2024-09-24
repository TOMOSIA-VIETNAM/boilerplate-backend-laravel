<?php

namespace App\Containers\RolePermission\Actions;

use Spatie\Permission\Models\Permission;

class DeletePermissionAction
{
    /**
     * @param int $id
     * @return bool|null
     */
    public function handle(int $id): bool|null
    {
        $permission = Permission::findOrFail($id);

        return $permission->delete();
    }
}
