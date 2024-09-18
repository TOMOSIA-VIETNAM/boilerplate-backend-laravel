<?php

namespace Modules\Admin\Services;

use App\Enums\PaginationEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Admin\Repositories\AdminRepository;
use Spatie\Permission\Models\Role;

class AdminService
{
    /**
     * @param AdminRepository $adminRepository
     */
    public function __construct(protected AdminRepository $adminRepository) {}

    /**
     * Summary of getLists
     * @return LengthAwarePaginator
     */
    public function getLists(): LengthAwarePaginator
    {
        return $this->adminRepository
            ->orderBy('created_at', 'DESC')
            ->paginate(PaginationEnum::ADMIN_PAGINATE);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function findById(int $id): Model|null
    {
        return $this->adminRepository->findById($id);
    }

    /**
     * @param int $id
     * @param int $roleId
     * @return bool
     */
    public function updateById(int $id, int $roleId): bool
    {
        $admin = $this->adminRepository->findById($id);
        if (!$admin) {
            return false;
        }

        $admin->syncRoles(Role::findById($roleId)->name);
        return true;
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function create(array $data): Model|null
    {
        $admin = $this->adminRepository->create($data);

        $admin->syncRoles(Role::findById($data['role_user'])->name);

        return $admin;
    }
}
