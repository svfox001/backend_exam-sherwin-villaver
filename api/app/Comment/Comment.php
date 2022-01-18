<?php

namespace App\Comment;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        "body",
        "commentable_type",
        "commentable_id",
        "creator_id",
        "parent_id"
    ];
}
