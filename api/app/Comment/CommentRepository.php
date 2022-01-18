<?php

namespace App\Comment;

use App\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    protected $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    public function findCommentsByPostId($id)
    {
        return $this->model->where('commentable_id', $id)->get();
    }
}