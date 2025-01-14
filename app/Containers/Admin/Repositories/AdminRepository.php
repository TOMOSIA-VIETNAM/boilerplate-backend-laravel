<?php

namespace App\Containers\Admin\Repositories;

use App\Containers\Admin\Models\Admin;
use App\Repositories\BaseRepository;

class AdminRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Admin::class;
    }
}
