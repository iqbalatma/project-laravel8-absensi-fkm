<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\CongressDayRepository;

class CongressDayService extends BaseService
{
    private const CONGRESS_DAY_SELECT_COLUMN = [
        "id", "location", "h_day",
    ];

    protected  $repository;

    public function __construct()
    {
        $this->repository = new CongressDayRepository();
    }
    /**
     * Description : use to get list data of congress day
     *
     * @return object
     */
    public function getAllData(): object
    {
        $data = $this->repository->getAllData(self::CONGRESS_DAY_SELECT_COLUMN);
        if ($data->count() == 0) {
            throw new EmptyDataException();
        }
        return $data;
    }


    /**
     * Description : use to get single data of congress day by id
     *
     * @param int $id of congress day
     * @return object
     */
    public function getDataById(int $id): ?object
    {
        $data = $this->repository->getDataById($id, self::CONGRESS_DAY_SELECT_COLUMN);
        if (empty($data)) {
            throw new EmptyDataException();
        }

        return $data;
    }


    /**
     * Description : Use for add new congress day
     *
     * @param array $requestedData
     * @return object
     */
    public function addNewData(array $requestedData): object
    {
        return $this->repository->addNewData($requestedData);
    }


    /**
     * Description : use to update congress day
     *
     * @param int $id of congress day
     * @param array $reuqestedData that already validated
     */
    public function updateDataById(int $id, array $requestedData): ?object
    {
        $this->checkData($id);
        return $this->repository->updateDataById($id, $requestedData, self::CONGRESS_DAY_SELECT_COLUMN);
    }


    /**
     * Description : Service for soft delete congress day
     *
     * @param int $id of congress day
     * @return bool status of deletion
     */
    public function deleteDataById(int $id): bool
    {
        $this->checkData($id);
        return $this->repository->deleteDataById($id);
    }
}
