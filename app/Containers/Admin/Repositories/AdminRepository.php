<?php

namespace App\Containers\Admin\Repositories;

use App\Containers\Admin\Models\Admin;
use App\Enums\PaginationEnum;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Admin::class;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getLists(): LengthAwarePaginator
    {
        return $this->model
            ->orderBy('created_at', 'DESC')
            ->paginate(PaginationEnum::ADMIN_PAGINATE);
    }
}
