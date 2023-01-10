<?php

namespace App\Repositories;

use App\Models\User;
use App\Statics\Table;

class UserRepository extends BaseRepository
{
    protected  $model;
    public function __construct()
    {
        $this->model = new User();
    }

    public function getAllDataPaginated(array $columns = ["*"], int $perPage = self::DEFAULT_PER_PAGE): ?object
    {
        return $this->model
            ->join(Table::ROLE, Table::ROLE . ".id", Table::USER . ".role_id")
            ->join(Table::ORGANIZATION, Table::ORGANIZATION . ".id", Table::USER . ".role_id")
            ->select($columns)
            ->paginate($perPage);
    }

    public function getDataById(int $id, array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->join(Table::ROLE, Table::ROLE . ".id", Table::USER . ".role_id")
            ->join(Table::ORGANIZATION, Table::ORGANIZATION . ".id", Table::USER . ".role_id")
            ->where(Table::USER . ".id", $id)
            ->first();
    }

    public function getDataByPersonalToken(string $personalToken, array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->where("personal_token", $personalToken)
            ->first();
    }

    public function changeActiveStatusById(int $id, bool $status = true): int
    {
        return $this->model
            ->where("id", $id)
            ->update(["is_active" => $status]);
    }
}
