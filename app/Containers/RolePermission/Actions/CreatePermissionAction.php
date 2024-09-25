<?php

namespace App\Containers\RolePermission\Actions;

use Spatie\Permission\Models\Permission;

class CreatePermissionAction
{
    /**
     * @param string $name
     * @return Permission
     */
    public function handle(string $name): Permission
    {
        return Permission::create(['name' => $name]);
    }
}
