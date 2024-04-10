<?php

namespace Modules\Api\Repositories\Parameters;

class AuthLoginParam
{
    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /**
     * AuthLoginParam constructor.
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
