<?php

namespace Modules\Admin\Traits\Auth;

use Illuminate\Contracts\View\View;

trait AuthLoginForm
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin::auth.login');
    }
}
