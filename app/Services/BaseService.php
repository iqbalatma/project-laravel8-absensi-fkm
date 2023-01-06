<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;

interface IService
{
    public function checkData(int $id): bool;
}
abstract class BaseService implements IService
{
    protected $repository;

    public function checkData(int $id): bool
    {
        $isExist = $this->repository->getDataById($id);
        if (!$isExist) {
            throw new EmptyDataException();
        }
        return true;
    }
}
