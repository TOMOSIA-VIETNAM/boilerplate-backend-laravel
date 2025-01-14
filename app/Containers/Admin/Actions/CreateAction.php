<?php

namespace App\Containers\Admin\Actions;

use App\Actions\BaseAction;
use App\Containers\Admin\Actions\LogActivity\LogCreatedAdminAction;
use App\Containers\Admin\Repositories\AdminRepository;
use Illuminate\Database\Eloquent\Model;

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
     * @param string $roleName
     * @return Model|null
     */
    public function handle(array $data, string $roleName)
    {
       #
    }
}
