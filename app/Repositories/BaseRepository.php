<?php

namespace App\Repositories;

interface IRepository
{
    public function getAllDataPaginated(array $columns = ["*"], int $perPage): ?object;
    public function getAllData(array $columns = ["*"]): ?object;
    public function getDataById(int $id, array $columns = ["*"]): ?object;
    public function addNewData(array $requestedData): object;
    public function updateDataById(int $id, array $requestedData): ?object;
    public function deleteDataById(int $id): int;
}


abstract class BaseRepository implements IRepository
{
    protected const DEFAULT_PER_PAGE = 5;
    protected  $model;

    public function getAllDataPaginated(array $columns = ["*"], int $perPage = self::DEFAULT_PER_PAGE): ?object
    {
        return $this->model
            ->select($columns)
            ->paginate($perPage);
    }
    public function getAllData(array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->get();
    }
    public function getDataById(int $id, array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->where("id", $id)
            ->first();
    }

    public function addNewData(array $requestedData): object
    {
        return $this->model
            ->create($requestedData);
    }
    public function updateDataById(int $id, array $requestedData, array $columns = ["*"]): ?object
    {
        $this->model
            ->where("id", $id)
            ->update($requestedData);

        return $this->model->find($id, $columns);
    }
    public function deleteDataById(int $id): int
    {
        return $this->model
            ->where("id", $id)
            ->delete();
    }
}
