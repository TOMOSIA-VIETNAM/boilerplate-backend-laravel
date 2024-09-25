<?php

namespace App\Containers\Admin\Actions;

use App\Actions\BaseAction;
use App\Containers\Admin\Repositories\AdminRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class CreateAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function repo(): mixed
    {
        return AdminRepository::class;
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function handle(array $data): Model|null
    {
        $admin = $this->repo->create($data);

        $admin->syncRoles(Role::findById($data['role_user'])->name);

        return $admin;
    }
}
