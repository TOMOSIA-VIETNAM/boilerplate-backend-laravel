<?php

namespace App\Containers\User\Repositories;

use App\Containers\User\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }
}
