<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Providers\AdminServiceProvider;
use Modules\Api\Providers\ApiServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(AdminServiceProvider::class);
        $this->app->register(ApiServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
