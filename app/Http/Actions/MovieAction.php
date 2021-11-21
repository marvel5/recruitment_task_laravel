<?php

namespace App\Http\Actions;

use External\Bar\Movies\MovieService;
use External\Baz\Movies\MovieService as BazMovieService;
use External\Foo\Movies\MovieService as FooMovieService;
use Illuminate\Support\Arr;

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
        $array1 =  $this->fooMovieService->getTitles();
        $array2  = Arr::flatten($this->barMovieService->getTitles());
        $array3 = Arr::flatten($this->bazMovieService->getTitles());
        return Arr::collapse([$array1, $array2, $array3]);
    }
}
