<?php

namespace App\Http\Actions;

use App\Http\Adapters\BarAdapter;
use App\Http\Adapters\BazAdapter;
use App\Http\Adapters\FooAdapter;
use Illuminate\Http\Request;

class LoginAction
{
    protected BarAdapter $barAdapter;
    protected BazAdapter $bazAdapter;
    protected FooAdapter $fooAdapter;

    public function __construct(BarAdapter $barAdapter, BazAdapter $bazAdapter, FooAdapter $fooAdapter)
    {
        $this->barAdapter = $barAdapter;
        $this->bazAdapter = $bazAdapter;
        $this->fooAdapter = $fooAdapter;
    }

    public function execute(Request $request): bool
    {
        return $this->barAdapter->login($request->login, $request->password) ||
            $this->bazAdapter->login($request->login, $request->password) ||
            $this->fooAdapter->login($request->login, $request->password);
    }
}
