<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\User\User;
use App\Post\Post;

class PostControllerTest extends TestCase
{
    /** @test */
    public function it_can_create_a_post()
    {
        $this->withoutExceptionHandling();

        $user = User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $payload = [
            'title' => 'Post Title',
            'content' => 'Post Content',
            'image' => 'Post Image',
        ];

        $response = $this->actingAs($user, 'api')
            ->post('/api/posts',$payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('posts', $payload);
    }

    /** @test */
    public function it_shoud_throw_validation_error() 
    {
        $user = User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        $token = $user->createToken('user')->accessToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json'
        ])->post('/api/posts', [])
        ->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_shoud_update_a_post()
    {
        $user = User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $token = $user->createToken('user')->accessToken;

        $post = Post::create([
            'title' => 'Post Title',
            'content' => 'Post Content',
            'image' => 'Post Image',
            'slug' => 'post-title',
            'user_id' => $user->id
        ]);

        $payload = [
            'title' => 'Second Post'  
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json'
        ])->patch('/api/posts/'.$post->slug, $payload)
        ->assertStatus(200);

        $response->assertJsonStructure([
            "data"
        ]);
    }

    /**
     * @test
     */
    public function it_should_delete_post() 
    {
        $user = User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $token = $user->createToken('user')->accessToken;

        $post = Post::create([
            'title' => 'Post Title',
            'content' => 'Post Content',
            'image' => 'Post Image',
            'slug' => 'post-title',
            'user_id' => $user->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json'
        ])->delete('/api/posts/'.$post->slug)
        ->assertStatus(200);
    }
    
    /** @test */
    public function it_shoud_show_post_per_slug()
    {
        $user = User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $post = Post::create([
            'title' => 'Post Title',
            'content' => 'Post Content',
            'image' => 'Post Image',
            'slug' => 'post-title',
            'user_id' => $user->id
        ]);

        $this->json('GET', '/api/posts/'.$post->slug)
            ->assertStatus(200);
    }

    /** @test */
    public function it_shoud_show_error_post_per_slug_not_found()
    {
        $user = User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $response = $this->json('GET', '/api/posts/first-post')
            ->assertStatus(404);
    }

    /** @test */
    public function it_shoud_show_all_posts()
    {
        $this->json('GET', '/api/posts/')
            ->assertStatus(200);
    }
}
