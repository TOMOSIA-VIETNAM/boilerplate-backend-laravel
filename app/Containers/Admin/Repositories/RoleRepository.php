<?php

namespace App\Containers\Admin\Repositories;

use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Role::class;
    }
}
