<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        return $this->handleWebRoutes();
    }

    /**
     * @return string|null
     */
    private function handleWebRoutes(): ?string
    {
        $routes = [
            'admin.*' => 'admin',
            'web.*'   => 'web'
        ];

        foreach ($routes as $pattern => $guard) {
            if (Route::is($pattern)) {
                Auth::shouldUse($guard);
                return route("{$guard}.login");
            }
        }

        return null;
    }
}
