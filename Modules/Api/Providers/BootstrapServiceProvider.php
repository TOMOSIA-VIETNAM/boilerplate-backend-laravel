<?php

namespace Modules\Api\Providers;

use App\Adapters\Clients\StorageClient;
use App\Adapters\Clients\StorageClientImpl;
use App\Securities\Authentications\AuthenticationManager;
use App\Securities\Authentications\BasicAuthenticationManager;
use Illuminate\Support\ServiceProvider;
use Modules\Api\Contracts\Services\AuthService;
use Modules\Api\Contracts\Services\UserService;
use Modules\Api\Services\AuthServiceImpl;
use Modules\Api\Services\UserServiceImpl;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
        $this->app->bind(StorageClient::class, StorageClientImpl::class);
        $this->app->bind(AuthenticationManager::class, BasicAuthenticationManager::class);
    }
}
