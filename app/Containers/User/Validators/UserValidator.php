<?php

namespace App\Containers\User\Validators;

use App\Containers\User\Data\DTOs\CreateUserDTO;
use App\Containers\User\Data\DTOs\UpdateUserDTO;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserValidator
{
    public function validateCreate(CreateUserDTO $dto): void
    {
        $validator = Validator::make($dto->toArray(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,user',
            'department' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }

    public function validateUpdate(UpdateUserDTO $dto, int $userId): void
    {
        $data = $dto->toArray();
        
        $validator = Validator::make($data, [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $userId,
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|string|in:admin,user',
            'department' => 'nullable|string|max:255',
            'status' => 'sometimes|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }
} 