<?php

namespace App\Containers\User\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function model(): string
    {
        return User::class;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->where('email', $email)->first();
    }

    public function findActive(): Collection
    {
        return $this->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findByRole(string $role): Collection
    {
        return $this->where('role', $role)
            ->with(['permissions', 'activities'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findByDepartment(string $department): Collection
    {
        return $this->where('department', $department)
            ->with(['permissions', 'activities'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findWithActivities(): Collection
    {
        return $this->with(['activities' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->whereHas('activities')
        ->get();
    }

    public function findWithFilters(array $filters, int $perPage = 0): Collection|LengthAwarePaginator
    {
        $query = $this->model->with(['permissions', 'activities']);

        if (isset($filters['search']) && !empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['department'])) {
            $query->where('department', $filters['department']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['recent_activities'])) {
            $hours = $filters['hours'] ?? 24;
            $query->with(['activities' => function ($query) use ($hours) {
                $query->where('created_at', '>=', now()->subHours($hours))
                    ->orderBy('created_at', 'desc');
            }])
            ->whereHas('activities', function ($query) use ($hours) {
                $query->where('created_at', '>=', now()->subHours($hours));
            });
        }

        $query->orderBy('created_at', 'desc');

        if ($perPage > 0) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    public function findWithPermissions(array $permissions): Collection
    {
        return $this->with(['permissions'])
            ->whereHas('permissions', function ($query) use ($permissions) {
                $query->whereIn('name', $permissions);
            })
            ->get();
    }

    public function findWithRecentActivities(int $hours = 24): Collection
    {
        return $this->with(['activities' => function ($query) use ($hours) {
            $query->where('created_at', '>=', now()->subHours($hours))
                ->orderBy('created_at', 'desc');
        }])
        ->whereHas('activities', function ($query) use ($hours) {
            $query->where('created_at', '>=', now()->subHours($hours));
        })
        ->get();
    }
} 