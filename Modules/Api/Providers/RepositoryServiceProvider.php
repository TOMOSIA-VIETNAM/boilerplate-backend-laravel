<?php

namespace Modules\Api\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Api\Contracts\Repositories\Mysql\UserRepository;
use Modules\Api\Repositories\Mysql\UserRepoImpl;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register repositories.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserRepoImpl::class);
    }
}
