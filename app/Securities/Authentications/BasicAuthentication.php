<?php

namespace App\Securities\Authentications;

use Modules\Api\Repositories\Auth;

class BasicAuthentication implements Authentication
{

    /** @var object|string */
    private $guards;

    /** @var BasicAuthenticationCredentials */
    private $credentials;

    /** @var object */
    private $userDetails;

    /** @var Auth */
    private $authenticatedCertificates;

    public function __construct(string $guards, string $username, string $password)
    {
        $this->guards = $guards;
        $this->credentials = new BasicAuthenticationCredentials($username, $password);
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    public function setUserDetails($user): void
    {
        $this->userDetails = $user;
    }

    public function getUserDetails()
    {
        return $this->userDetails;
    }

    public function setAuthenticatedCertificates(Auth $authenticatedCertificates): void
    {
        $this->authenticatedCertificates = $authenticatedCertificates;
    }

    public function getAuthenticatedCertificates()
    {
        return $this->authenticatedCertificates;
    }

    public function getGuards()
    {
        return $this->guards;
    }
}
