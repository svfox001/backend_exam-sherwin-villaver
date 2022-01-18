<?php

namespace App\User;

use App\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $model;   

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}