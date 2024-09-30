<?php

namespace App\Containers\Admin\Actions;

use App\Actions\BaseAction;
use App\Containers\Admin\Actions\LogActivity\LogUpdatedAdminAction;
use App\Containers\Admin\Repositories\AdminRepository;

class UpdateAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function repo(): mixed
    {
        return AdminRepository::class;
    }

    /**
     * @param int $id
     * @param int $currentRoleName
     * @return bool
     */
    public function handle(int $id, string $currentRoleName): bool
    {
        $admin = $this->repo->findById($id);
        if (!$admin) {
            return false;
        }

        $previousRoleName = $admin->roles?->first()?->name ?? '';
        $admin->syncRoles($currentRoleName);
        resolve(LogUpdatedAdminAction::class)->handle($admin, $previousRoleName, $currentRoleName);

        return true;
    }
}
