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

    public function getDataByPersonalToken(string $personalToken, array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->where("personal_token", $personalToken)
            ->first();
    }
}
