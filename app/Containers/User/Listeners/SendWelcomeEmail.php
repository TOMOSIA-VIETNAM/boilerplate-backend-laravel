<?php

namespace App\Containers\User\Listeners;

use App\Containers\User\Events\UserCreated;
use App\Shared\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        protected EmailService $emailService
    ) {}

    public function handle(UserCreated $event): void
    {
        $this->emailService->sendWelcomeEmail(
            $event->user->email,
            $event->user->name
        );
    }
} 