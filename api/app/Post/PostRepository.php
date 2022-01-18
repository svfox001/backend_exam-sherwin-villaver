<?php

namespace App\Post;

use App\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * @var Post
     */
    protected $model;

    /**
     * PostRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function updateBySlug($slug, array $data)
    {
        $this->model->where('slug', $slug)->update($data);
    }

    public function deleteBySlug($slug)
    {
        $this->model->where('slug', $slug)->delete();
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function paginate($count)
    {
        return $this->model->paginate($count);
    }
}