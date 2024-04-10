<?php

namespace Modules\Api\Services;

use App\Exceptions\ApiException;
use App\Securities\Authentications\AuthenticationManager;
use App\Securities\Authentications\BasicAuthentication;
use Modules\Api\Constants\UserStatus;
use Modules\Api\Contracts\Services\AuthService;
use Modules\Api\Repositories\Auth;
use Modules\Api\Repositories\Parameters\AuthLoginParam;

class AuthServiceImpl implements AuthService
{
    /** @var AuthenticationManager */
    private AuthenticationManager $authenticationManager;

    public function __construct(AuthenticationManager $authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * Login service
     *
     * @param AuthLoginParam $param
     * @return Auth
     */
    public function login(AuthLoginParam $param): Auth
    {
        $basicAuth = new BasicAuthentication("api", $param->email, $param->password);
        $authenticatedObject = $this->authenticationManager->authenticate($basicAuth);
        if ($authenticatedObject->getUserDetails()->status === UserStatus::INACTIVE) {
            throw ApiException::forbidden('Your account has been disabled');
        }

        /** @var Auth $authToken */
        $authToken = $authenticatedObject->getAuthenticatedCertificates();

        return $authToken;
    }
}
