<?php

namespace App\Securities\Authentications;

use App\Exceptions\ApiException;
use App\Securities\Exceptions\AuthenticationException;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Modules\Api\Repositories\Auth;

class BasicAuthenticationManager implements AuthenticationManager
{
    public function authenticate(Authentication $auth): Authentication
    {
        $credentials = $auth->getCredentials();
        if (!$credentials instanceof BasicAuthenticationCredentials) {
            throw new AuthenticationException("Not support for this credentials");
        }
        $basicAuth = new BasicAuthentication(
            $auth->getGuards(),
            $credentials->getUsername(),
            $credentials->getPassword(),
        );
        $token = $this->getGuards($basicAuth->getGuards())->attempt([
            'email' => $basicAuth->getCredentials()->getUsername(),
            'password' => $basicAuth->getCredentials()->getPassword(),
        ]);
        if (! $token) {
            throw ApiException::forbidden('Email or password was incorrect');
        }

        $userDetails = $this->getGuards($basicAuth->getGuards())->user();
        $basicAuth->setUserDetails($userDetails);

        $authToken = new Auth($token);
        $basicAuth->setAuthenticatedCertificates($authToken);

        return $basicAuth;
    }

    /**
     * Returns authentication guards.
     * This could be guards for normal user or administrator...
     *
     * @param string $provider
     * @return Factory|Guard|StatefulGuard
     */
    public function getGuards(string $provider)
    {
        return auth($provider);
    }

    public function getTokenExpirationTime()
    {
        return time() + config('jwt.ttl');
    }
}
