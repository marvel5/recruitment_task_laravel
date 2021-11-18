<?php

namespace App\Http\Adapters;

use App\Http\Interfaces\Login;
use External\Foo\Auth\AuthWS;

class FooAdapter implements Login
{
    private AuthWS $service;

    public function __construct(AuthWS $service)
    {
        $this->service = $service;
    }

    public function login(string $login, string $password): bool
    {
        return $this->service->authenticate($login, $password) === null;
    }
}
