<?php

namespace App\Containers\User\Events;

use App\Containers\User\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly User $user
    ) {}
} 