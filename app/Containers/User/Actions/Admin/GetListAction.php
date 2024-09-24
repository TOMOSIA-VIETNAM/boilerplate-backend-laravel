<?php

namespace App\Containers\User\Actions\Admin;

use App\Actions\BaseAction;
use App\Containers\User\Repositories\UserRepository;

class GetListAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function repo(): mixed
    {
        return UserRepository::class;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        return $this->repo->getLists();
    }
}
