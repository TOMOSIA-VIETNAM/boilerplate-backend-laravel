<?php

namespace App\Shared;

use App\Shared\ActivityLog\ActivityLogMethod;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\ActivityLogger;

class SharedProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ActivityLogger::class, ActivityLogMethod::class);
    }
}
