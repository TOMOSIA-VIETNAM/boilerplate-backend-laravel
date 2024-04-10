<?php

namespace App\Securities\Authentications;

interface AuthenticationManager
{
    public function authenticate(Authentication $auth): Authentication;
}
