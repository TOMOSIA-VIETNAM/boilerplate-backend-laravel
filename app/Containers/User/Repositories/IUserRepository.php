<?php

namespace App\Containers\User\Repositories;

use App\Core\Repositories\IBaseRepository;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IUserRepository extends IBaseRepository
{
    public function findByEmail(string $email): ?User;
    public function findActive(): Collection;
    public function findByRole(string $role): Collection;
    public function findByDepartment(string $department): Collection;
    public function findWithActivities(): Collection;
    public function findWithFilters(array $filters, int $perPage = 0): Collection|LengthAwarePaginator;
    public function findWithPermissions(array $permissions): Collection;
    public function findWithRecentActivities(int $hours = 24): Collection;
} 