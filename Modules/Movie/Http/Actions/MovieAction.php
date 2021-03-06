<?php

namespace Modules\Movie\Http\Actions;

use External\Bar\Movies\MovieService;
use External\Baz\Movies\MovieService as BazMovieService;
use External\Foo\Movies\MovieService as FooMovieService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Modules\Movie\Definitions\MovieDefinition;

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
        if ($this->isCached()) {
            return  Cache::get(MovieDefinition::MOVIES_CACHE_KEY);
        }
        Cache::put('movies', $this->collapseMovies(), 3600);
        return $this->collapseMovies();
    }

    protected function isCached(): bool
    {
        return Cache::has(MovieDefinition::MOVIES_CACHE_KEY);
    }

    protected function collapseMovies(): array
    {
        return Arr::collapse([
            $this->fooMovieService->getTitles(),
            Arr::flatten($this->barMovieService->getTitles()),
            Arr::flatten($this->bazMovieService->getTitles())
        ]);
    }
}
