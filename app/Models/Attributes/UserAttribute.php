<?php

namespace App\Models\Attributes;

trait UserAttribute
{
    /**
     * @param ?string $path
     * @return string
     */
    public function getImageUrl(?string $path): string
    {
        return $this->getPublicUrl($path) ?? asset('assets/images/avatars/default-avatar.webp');
    }
}
