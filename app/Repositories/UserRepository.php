<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    protected  $model;
    public function __construct()
    {
        $this->model = new User();
    }
}
