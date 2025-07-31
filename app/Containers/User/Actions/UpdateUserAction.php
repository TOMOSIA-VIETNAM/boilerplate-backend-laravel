<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Data\DTOs\UpdateUserDTO;
use App\Containers\User\Models\User;
use App\Containers\User\Repositories\IUserRepository;
use App\Containers\User\Validators\UserValidator;
use App\Containers\User\Events\UserUpdated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateUserAction
{
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly UserValidator $validator
    ) {}

    public function execute(int $id, UpdateUserDTO $dto): ?User
    {
        // Validate
        $this->validator->validateUpdate($dto, $id);

        return DB::transaction(function () use ($id, $dto) {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return null;
            }

            $userData = $dto->toArray();
            if (isset($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            }

            $updatedUser = $this->userRepository->updateById($id, $userData);
            
            if ($updatedUser) {
                // Dispatch events
                Event::dispatch(new UserUpdated($updatedUser));
            }
            
            return $updatedUser;
        });
    }
} 