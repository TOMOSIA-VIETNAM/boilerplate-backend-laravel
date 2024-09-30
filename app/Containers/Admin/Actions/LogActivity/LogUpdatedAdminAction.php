<?php

namespace App\Containers\Admin\Actions\LogActivity;

use App\Containers\Admin\Models\Admin;

class LogUpdatedAdminAction
{
    /**
     * @param Admin $admin
     * @param string $previousRoleName
     * @param string $currentRoleName
     * @return void
     */
    public function handle(Admin $admin, string $previousRoleName, string $currentRoleName): void
    {
        $admin->logUpdated($previousRoleName, $currentRoleName);
    }
}
