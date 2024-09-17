<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Services\UserService;

class UserController extends AdminController
{
    /**
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService) {}

    public function index()
    {
        return view('admin::users.index');
    }
}
