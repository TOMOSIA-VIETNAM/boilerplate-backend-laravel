<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Repositories\IUserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GetUsersAction
{
    public function __construct(
        private readonly IUserRepository $userRepository
    ) {}

    public function execute(array $filters = []): Collection|LengthAwarePaginator
    {
        $perPage = 0;
        
        if (isset($filters['per_page'])) {
            $perPage = (int) $filters['per_page'];
            unset($filters['per_page']);
        }

        if (isset($filters['paginate']) && $filters['paginate'] === true) {
            $perPage = $perPage > 0 ? $perPage : 15; // Default 15 items per page
            unset($filters['paginate']);
        }

        return $this->userRepository->findWithFilters($filters, $perPage);
    }
} 