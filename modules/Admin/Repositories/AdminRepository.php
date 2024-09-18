<?php

namespace Modules\Admin\Repositories;

use App\Models\Admin;

class AdminRepository extends BaseRepository
{
    /**
     * @param Admin $model
     */
    public function __construct(Admin $model)
    {
        $this->model = $model;
    }
}
