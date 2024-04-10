<?php

namespace Modules\Api\Repositories\Mysql;

use App\Models\User;
use Modules\Api\Contracts\Repositories\Mysql\UserRepository;

class UserRepoImpl implements UserRepository
{
    /**
     * Save User to database
     *
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    /**
     * Get User by id
     *
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return User::query()
            ->find($userId);
    }
}
