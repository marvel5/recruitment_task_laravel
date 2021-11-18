<?php

namespace App\Http\Adapters;

use App\Http\Interfaces\Login;
use External\Bar\Auth\LoginService;

class BarAdapter implements Login
{
    private LoginService $service;

    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    public function login(string $login, string $password): bool
    {
        return $this->service->login($login, $password);
    }
}
