<?php

namespace Modules\Api\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
