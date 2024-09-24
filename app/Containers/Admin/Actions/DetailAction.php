<?php

namespace App\Containers\Admin\Actions;

use App\Actions\BaseAction;
use App\Containers\Admin\Repositories\AdminRepository;
use Illuminate\Database\Eloquent\Model;

class DetailAction extends BaseAction
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
     * @return Model|null
     */
    public function handle(int $id): Model|null
    {
        return $this->repo->findById($id);
    }
}
