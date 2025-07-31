<?php

namespace App\Containers\User\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserDeleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly int $userId
    ) {}
} 