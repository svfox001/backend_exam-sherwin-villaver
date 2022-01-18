<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User\User;
use App\Post\Post;
use App\Comment\Comment;

class CommentControllerTest extends TestCase
{
    /** @test */
    public function it_should_create_a_comment()
    {
        $this->withoutExceptionHandling();
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
            "body" => "Test Body",
            "post_id" => $post->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json'
        ])->post('/api/posts/' . $post->slug . '/comments',$payload)
        ->assertStatus(201);
    }

    /** @test */
    public function it_shoud_update_a_comment()
    {
        $this->withoutExceptionHandling();
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

        $comment = Comment::create([
            'body' => 'Test Body',
            'commentable_type' => 'App\\Post',
            'commentable_id' => $post->id,
            'creator_id' => $user->id
        ]);

        $payload = [
            "body" => "Test Body Updated"
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json'
        ])->patch('/api/posts/' . $post->slug.'/comments/'.$comment->id, $payload)
        ->assertStatus(200);
    }

    /** @test */
    public function it_shoud_delete_a_comment()
    {
        $this->withoutExceptionHandling();
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

        $comment = Comment::create([
            'body' => 'Test Body',
            'commentable_type' => 'App\\Post',
            'commentable_id' => $post->id,
            'creator_id' => $user->id
        ]);

        $payload = [
            "body" => "Test Body Updated"
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json'
        ])->delete('/api/posts/' . $post->slug.'/comments/'.$comment->id)
        ->assertStatus(200);
    }

    /** @test */
    public function it_should_show_comment_by_slug()
    {
        $this->withoutExceptionHandling();
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

        $this->json('GET', '/api/posts/'.$post->id.'/comments')
            ->assertStatus(200);

    }
}
