<?php

namespace App\Containers\User\Data\DTOs;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UploadAvatarDTO
{
    public function __construct(
        public readonly UploadedFile $avatar,
        public readonly int $userId
    ) {}

    public static function fromRequest(Request $request, int $userId): self
    {
        return new self(
            avatar: $request->file('avatar'),
            userId: $userId
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            avatar: $data['avatar'],
            userId: $data['user_id']
        );
    }
} 