<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private $user = [
        'name' => 'John Doe',
        'email' => 'johndoe@test.pl',
        'password' => 'password'
    ];
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredFieldsForRegister()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'name' => ['The name field is required.'],
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.']
                    ]
                ]
            );
    }

    public function testSuccessCreateNewUser()
    {
        $this->json('POST', 'api/register', $this->user)
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testAddTheSameUser()
    {
        $this->json('POST', 'api/register', $this->user)
            ->assertStatus(Response::HTTP_CREATED);

        $this->json('POST', 'api/register', $this->user)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'email' => [
                        'The email has already been taken.'
                    ]
                ]
            ]);
    }

    public function testGetUserWithMiddleware()
    {
        $this->json('GET', 'api/user')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetUser()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('api/user')
            ->assertStatus(Response::HTTP_OK);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->get(route('logout'))
            ->assertStatus(Response::HTTP_OK);
    }
}
