<?php

namespace App\Containers\User\Data\DTOs;

use Illuminate\Http\Request;

class CreateUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $role = null,
        public readonly ?string $department = null,
        public readonly array $permissions = []
    ) {}

    public static function fromRequest(Request|array $data): self
    {
        // Nếu là Request object, lấy tất cả data
        if ($data instanceof Request) {
            $data = $data->all();
        }

        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            role: $data['role'] ?? null,
            department: $data['department'] ?? null,
            permissions: $data['permissions'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'department' => $this->department,
            'permissions' => $this->permissions
        ];
    }
} 