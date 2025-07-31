<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use App\Containers\User\Repositories\IUserRepository;

class GetUserByIdAction
{
    public function __construct(
        private readonly IUserRepository $userRepository
    ) {}

    public function execute(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
} 