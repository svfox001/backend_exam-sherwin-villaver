<?php

namespace App\Comment;

use App\EloquentRepositoryInterface;

interface CommentRepositoryInterface extends EloquentRepositoryInterface
{
    public function findCommentsByPostId($id);
}