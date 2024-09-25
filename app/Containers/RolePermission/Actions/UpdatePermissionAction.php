<?php

namespace App\Containers\RolePermission\Actions;

use Spatie\Permission\Models\Permission;

class UpdatePermissionAction
{
    /**
     * @param int $id
     * @param string $name
     * @return bool
     */
    public function handle(int $id, string $name): bool
    {
        $permission = Permission::findOrFail($id);
        return $permission->update(['name' => $name]);
    }
}
