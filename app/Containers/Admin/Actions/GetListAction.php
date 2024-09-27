<?php

namespace App\Containers\Admin\Actions;

use App\Actions\BaseAction;
use App\Containers\Admin\Repositories\AdminRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class GetListAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function repo(): mixed
    {
        return AdminRepository::class;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function handle(): LengthAwarePaginator
    {
        return $this->repo->getLists();
    }
}
