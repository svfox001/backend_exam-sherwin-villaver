<?php

namespace App\Post;

use Illuminate\Database\Eloquent\Model;
use Str;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'image', 'user_id', 'slug'
    ];
}
