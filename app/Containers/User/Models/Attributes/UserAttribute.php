<?php

namespace App\Containers\User\Models\Attributes;

use App\Shared\Storage\StorageClient;

trait UserAttribute
{
    /**
     * @param ?string $path
     * @return string
     */
    public function getImageUrl(?string $path): string
    {
        return (new StorageClient())->getPublicUrl($path) ?? asset('assets/images/avatars/default-avatar.webp');
    }
}
