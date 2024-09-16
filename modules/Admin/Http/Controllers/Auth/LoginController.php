<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\Admin\Http\Requests\Auth\LoginRequest;
use Modules\Admin\Traits\Auth\AuthLoginForm;
use Modules\Admin\Http\Controllers\AdminController;

class LoginController extends AdminController
{
    use AuthLoginForm;

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect('/admin');
    }
}
