<?php

namespace App\Containers\RolePermission\Actions;

use Spatie\Permission\Models\Permission;

class AssignPermissionToRoleAction
{
    /**
     * @param array $data
     * @return void
     */
    public function handle(array $data): void
    {
        foreach ($data as $permissionName => $roles) {
            $permissionInstance = Permission::findByName($permissionName);
            if (!empty($permissionInstance)) {
                $permissionInstance->syncRoles(roles: $roles);
            }
        }
    }
}
