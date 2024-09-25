<?php

namespace App\Containers\Admin\Actions;

use App\Actions\BaseAction;
use App\Containers\Admin\Repositories\AdminRepository;
use Spatie\Permission\Models\Role;

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
     * @param int $roleId
     * @return bool
     */
    public function handle(int $id, int $roleId): bool
    {
        $admin = $this->repo->findById($id);
        if (!$admin) {
            return false;
        }

        $admin->syncRoles(Role::findById($roleId)->name);
        return true;
    }
}
