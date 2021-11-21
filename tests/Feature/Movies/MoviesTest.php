<?php

namespace Tests\Feature\Movies;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class MoviesTest extends TestCase
{
    public function testGetMovies()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->get('api/titles')
            ->assertStatus(Response::HTTP_OK);
    }
}
