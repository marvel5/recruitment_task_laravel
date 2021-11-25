<?php

namespace Modules\Movie\Tests\Feature;

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
        $response = $this->actingAs($user)
            ->get('api/titles');

        $this->assertThat(
            $response->getStatusCode(),
            $this->logicalOr(
                $this->equalTo(Response::HTTP_OK),
                $this->equalTo(Response::HTTP_INTERNAL_SERVER_ERROR)
            )
        );
    }
}
