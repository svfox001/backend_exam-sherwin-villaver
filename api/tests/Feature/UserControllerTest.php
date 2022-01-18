<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User\User;

class UserControllerTest extends TestCase
{
    /** @test */
    public function it_shoud_create_user() {
        $this->withoutExceptionHandling();
        $payload = [
            'name' => 'John Doe',
            'email' => 'example@gmail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];
        
        $this->json('POST', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'name',
                    'email',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            );

        unset($payload['password_confirmation']);
        $this->assertDatabaseHas('users', $payload);
    }

    /** @test */
    public function it_should_throw_validation_error()
    {
        $payload = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ];
        $response = $this->json('POST', '/api/register', $payload)
            ->assertStatus(422);

        $response->assertJsonStructure([
            "message",
            "errors"
        ]);
    }

    /** @test */
    public function it_shoud_login_user()
    {
        //Create user
        User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        
        $payload = [
            'email' => 'test@gmail.com',
            'password' => 'secret1234'
        ];

        $this->json('POST', '/api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'token_type',
                'expires_at'
            ]);
    }

    /** @test */
    public function it_shoud_throw_error()
    {
        //Create user
        User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $payload = [
            'email' => 'sss',
            'password' => ''
        ];

        $response = $this->json('POST', '/api/login', $payload)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    /** @test */
    public function it_shoud_logout_user()
    {
        $user = User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        $token = $user->createToken('user')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', '/api/logout', [], $headers)
            ->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully']);
    }
}
