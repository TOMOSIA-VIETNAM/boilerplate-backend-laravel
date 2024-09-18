<?php

namespace App\Containers\Admin\Actions\Role;

use App\Actions\BaseAction;
use App\Containers\Admin\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\Model;

class FindByIdAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function repo(): mixed
    {
        return RoleRepository::class;
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function handle(int $id): Model|null
    {
        return $this->repo->findById($id);
    }
}
