<?php

namespace App\Containers\User\Repositories;

use App\Containers\User\Models\User;
use App\Enums\PaginationEnum;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getLists(): LengthAwarePaginator
    {
        return $this->model->orderBy('created_at', 'DESC')
            ->paginate(PaginationEnum::ADMIN_PAGINATE);
    }
}
