<?php

namespace Modules\Admin\Services;

use App\Models\User;
use Modules\Admin\Repositories\UserRepository;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(protected UserRepository $userRepository) {}

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
