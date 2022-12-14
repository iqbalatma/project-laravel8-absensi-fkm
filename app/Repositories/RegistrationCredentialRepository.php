<?php

namespace App\Repositories;

use App\Exceptions\EmptyDataException;
use App\Models\RegistrationCredential;
use Illuminate\Support\Facades\DB;

class RegistrationCredentialRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new RegistrationCredential();
    }

    public function getDataByToken(string $token, array $columns = ["*"])
    {
        return $this->model
            ->select($columns)
            ->where("token", $token)
            ->first();
    }

    public function decreaseLimitByToken(string $token, int $value = 1)
    {
        return $this->model->where("token", $token)->decrement("limit", $value);
    }
}
