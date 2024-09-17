<?php

namespace Modules\Admin\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }
}
