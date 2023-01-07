<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\AssetRepository;
use App\Repositories\OrganizerNotificationRepository;

class OrganizerNotificationService extends BaseService
{

    protected $repository;

    public function __construct()
    {
        $this->repository = new OrganizerNotificationRepository();
    }
    /**
     * Description : use to get all data asset
     *
     * @return object of eloquent
     */
    public function getAllData(): object
    {
        $data = $this->repository->getAllData();
        if ($data->count() == 0) {
            throw new EmptyDataException();
        }
        return $data;
    }


    /**
     * Description : use to get latest notification
     *
     * @return object of eloquent
     */
    public function getLatestData(): object
    {
        $data = $this->repository->getLatestData();
        if (empty($data)) {
            throw new EmptyDataException();
        }

        return $data;
    }


    /**
     * Description : use to add new notification
     *
     * @param array $requestedData to store new notification
     * @return object of eloquent
     */
    public function store(array $requestedData): object
    {
        return $this->repository->addNewData($requestedData);
    }
}
