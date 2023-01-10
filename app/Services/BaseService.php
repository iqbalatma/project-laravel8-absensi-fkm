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
    protected object $data;

    public function checkData(int $id): bool
    {
        $this->setData($this->repository->getDataById($id));
        $isExist = $this->getData();
        if (!$isExist) {
            throw new EmptyDataException();
        }
        return true;
    }

    /**
     * @return object
     */
    public function getData(): object
    {
        return $this->data;
    }

    /**
     * @param object $data
     * @return self
     */
    public function setData(object $data): self
    {
        $this->data = $data;
        return $this;
    }
}
