<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\EloquentRepositoryInterface;
use App\User\UserRepositoryInterface;
use App\Post\PostRepositoryInterface;
use App\Comment\CommentRepositoryInterface;


use App\BaseRepository;
use App\User\UserRepository;
use App\Post\PostRepository;
use App\Comment\CommentRepository;



class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
