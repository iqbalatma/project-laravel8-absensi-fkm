<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function getAllData(array $columns = ["*"]): ?object;
    public function getDataById(int $id, array $columns = ["*"]): ?object;
    public function addNewData(array $requestedData): object;
    public function updateDataById(int $id, array $requestedData): object;
    public function deleteDataById(int $id): int;
}


abstract class BaseRepository implements IRepository
{
    protected const DEFAULT_PER_PAGE = 5;
    protected  $model;

    public function getAllData(array $columns = ["*"], int $perPage = self::DEFAULT_PER_PAGE): ?object
    {
        return $this->model
            ->select($columns)
            ->paginate($perPage);
    }
    public function getDataById(int $id, array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->where("id", $id)
            ->get();
    }

    public function addNewData(array $requestedData): object
    {
        return $this->model
            ->create($requestedData);
    }
    public function updateDataById(int $id, array $requestedData): object
    {
        $this->model
            ->where("id", $id)
            ->update($requestedData);

        return $this->model->find($id);
    }
    public function deleteDataById(int $id): int
    {
        return $this->model
            ->where("id", $id)
            ->delete();
    }
}
