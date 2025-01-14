<?php

namespace Modules\Company\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register global params for all views.
     */
    public function boot(): void
    {
        View::composer('company::*', function ($view) {
            $data = [];

            $view->with($data);
        });
    }
}
