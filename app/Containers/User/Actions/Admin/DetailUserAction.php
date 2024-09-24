<?php

namespace App\Containers\User\Actions\Admin;

use App\Actions\BaseAction;
use App\Containers\User\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class DetailUserAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function repo(): mixed
    {
        return UserRepository::class;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function handle(int $id): Model
    {
        return $this->repo->findById($id);
    }
}
