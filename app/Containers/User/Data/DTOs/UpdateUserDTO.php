<?php

namespace App\Containers\User\Data\DTOs;

use Illuminate\Http\Request;

class UpdateUserDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
        public readonly ?string $role = null,
        public readonly ?string $department = null,
        public readonly ?array $permissions = null,
        public readonly ?string $status = null
    ) {}

    public static function fromRequest(Request|array $data): self
    {
        // Nếu là Request object, lấy tất cả data
        if ($data instanceof Request) {
            $data = $data->all();
        }

        return new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
            role: $data['role'] ?? null,
            department: $data['department'] ?? null,
            permissions: $data['permissions'] ?? null,
            status: $data['status'] ?? null
        );
    }

    public function toArray(): array
    {
        $data = [];
        
        if ($this->name !== null) {
            $data['name'] = $this->name;
        }
        if ($this->email !== null) {
            $data['email'] = $this->email;
        }
        if ($this->password !== null) {
            $data['password'] = $this->password;
        }
        if ($this->role !== null) {
            $data['role'] = $this->role;
        }
        if ($this->department !== null) {
            $data['department'] = $this->department;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
        }

        return $data;
    }

    public function hasPermissions(): bool
    {
        return $this->permissions !== null;
    }

    public function getPermissions(): ?array
    {
        return $this->permissions;
    }
} 