<?php

namespace App\Http\Interfaces;

interface Login
{
    public function login(string $login, string $password): bool;
}
