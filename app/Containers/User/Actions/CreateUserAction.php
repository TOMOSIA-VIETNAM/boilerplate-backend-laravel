<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Data\DTOs\CreateUserDTO;
use App\Containers\User\Models\User;
use App\Containers\User\Repositories\IUserRepository;
use App\Containers\User\Validators\UserValidator;
use App\Containers\User\Events\UserCreated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateUserAction
{
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly UserValidator $validator
    ) {}

    public function execute(CreateUserDTO $dto): User
    {
        // Validate
        $this->validator->validateCreate($dto);

        return DB::transaction(function () use ($dto) {
            $userData = $dto->toArray();
            $userData['password'] = Hash::make($userData['password']);
            
            $user = $this->userRepository->create($userData);
            
            // Dispatch events
            Event::dispatch(new UserCreated($user));
            
            return $user;
        });
    }
}
