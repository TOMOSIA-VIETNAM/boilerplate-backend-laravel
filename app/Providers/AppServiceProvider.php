<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Api\Providers\ApiServiceProvider;
use Modules\Admin\Providers\AdminServiceProvider;
use App\Containers\User\Repositories\IUserRepository;
use App\Containers\User\Repositories\UserRepository;
use App\Containers\Blog\Repositories\IBlogRepository;
use App\Containers\Blog\Repositories\BlogRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(ApiServiceProvider::class);
        $this->app->register(AdminServiceProvider::class);
        // Register User Repository
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IBlogRepository::class, BlogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
