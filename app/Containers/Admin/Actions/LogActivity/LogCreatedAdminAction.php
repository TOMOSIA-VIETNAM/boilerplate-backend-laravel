<?php

namespace App\Containers\Admin\Actions\LogActivity;

use App\Containers\Admin\Models\Admin;

class LogCreatedAdminAction
{
    /**
     * @param Admin $admin
     * @param string $roleName
     * @return void
     */
    public function handle(Admin $admin, string $roleName): void
    {
        $admin->logCreated($roleName);
    }
}
