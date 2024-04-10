<?php

namespace App\Securities\Authentications;

class BasicAuthenticationCredentials
{
    /** @var string  */
    private $username;

    /** @var string  */
    private $password;

    /**
     * BasicAuthenticationCredentials constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
