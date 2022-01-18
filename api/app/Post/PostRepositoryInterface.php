<?php

namespace App\Post;

use App\EloquentRepositoryInterface;

interface PostRepositoryInterface extends EloquentRepositoryInterface
{
    public function updateBySlug($slug, array $data);
    public function deleteBySlug($slug);
    public function findBySlug($slug);
    public function paginate($count);
}