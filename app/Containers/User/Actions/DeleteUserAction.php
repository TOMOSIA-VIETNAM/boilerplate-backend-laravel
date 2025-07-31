<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Repositories\IUserRepository;
use App\Containers\User\Events\UserDeleted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeleteUserAction
{
    public function __construct(
        private readonly IUserRepository $userRepository
    ) {}

    public function execute(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return false;
            }

            $deleted = $this->userRepository->deleteById($id);
            
            if ($deleted) {
                // Dispatch events
                Event::dispatch(new UserDeleted($id));
            }
            
            return $deleted;
        });
    }
} 