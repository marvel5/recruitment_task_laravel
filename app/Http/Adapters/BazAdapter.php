<?php

namespace App\Http\Adapters;

use App\Http\Interfaces\Login;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;

class BazAdapter implements Login
{
    private Authenticator $service;

    public function __construct(Authenticator $service)
    {
        $this->service =  $service;
    }

    public function login(string $login, string $password): bool
    {
        return $this->service->auth($login, $password) instanceof Success;
    }
}
