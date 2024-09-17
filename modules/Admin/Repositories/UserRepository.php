<?php

namespace Modules\Admin\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
