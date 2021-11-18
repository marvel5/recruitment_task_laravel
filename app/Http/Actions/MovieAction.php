<?php

namespace App\Http\Actions;

use External\Bar\Movies\MovieService;
use External\Baz\Movies\MovieService as BazMovieService;
use External\Foo\Movies\MovieService as FooMovieService;

class MovieAction
{

    protected MovieService $barMovieService;
    protected BazMovieService $bazMovieService;
    protected FooMovieService $fooMovieService;

    public function __construct(MovieService $barMovieService, BazMovieService $bazMovieService, FooMovieService $fooMovieService)
    {
        $this->barMovieService = $barMovieService;
        $this->bazMovieService = $bazMovieService;
        $this->fooMovieService = $fooMovieService;
    }


    public function execute(): array
    {
        $number = rand(0, 2);
        if ($number === 0) {
            return $this->fooMovieService->getTitles();
        } else if ($number === 1) {
            return $this->barMovieService->getTitles();
        } else if ($number === 2) {
            return $this->bazMovieService->getTitles();
        }
    }
}
