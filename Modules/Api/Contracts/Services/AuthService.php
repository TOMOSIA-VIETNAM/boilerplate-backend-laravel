<?php

namespace Modules\Api\Contracts\Services;

use Modules\Api\Repositories\Auth;
use Modules\Api\Repositories\Parameters\AuthLoginParam;

interface AuthService
{
    /**
     * Login service
     *
     * @param AuthLoginParam $param
     * @return Auth
     */
    public function login(AuthLoginParam $param): Auth;
}
