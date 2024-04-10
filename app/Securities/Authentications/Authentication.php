<?php

namespace App\Securities\Authentications;

interface Authentication
{
    /**
     * The credentials that prove the authentication request is correct. This is usually a password,
     * but could be anything relevant to the AuthenticationManager.
     *
     * @return object|array
     */
    public function getCredentials();

    /**
     * Stores additional details about the authentication request.
     *
     * @return object|array
     */
    public function getUserDetails();

    /**
     * The certificates that returned by authentication process.
     * This is usually tokens (access token, refresh token) or authentication session...
     *
     * @return object|array
     */
    public function getAuthenticatedCertificates();
}
