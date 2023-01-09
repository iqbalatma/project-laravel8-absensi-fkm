<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\OrganizationRepository;

class OrganizationService extends BaseService
{
    private const ORGANIZATION_SELECT_COLUMN = [
        "id",
        "name",
        "shortname",
        "link_instagram",
        "link_website",
        "created_at",
    ];

    protected $repository;

    public function __construct()
    {
        $this->repository = new OrganizationRepository();
    }
    /**
     * Description : use to get all data organization
     *
     * @return object of eloquent model
     */
    public function getAllDataPaginated(): object
    {
        $data = $this->repository->getAllDataPaginated(self::ORGANIZATION_SELECT_COLUMN);
        if ($data->count() == 0) {
            throw new EmptyDataException();
        }

        return $data;
    }


    /**
     * Description : use to get organization by id
     *
     * @param int $id of organization
     * @return object of eloquent model
     */
    public function getDataById(int $id): object
    {
        $data = $this->repository->getDataById($id, self::ORGANIZATION_SELECT_COLUMN);
        if (empty($data)) {
            throw new EmptyDataException();
        }
        return $data;
    }


    /**
     * Description : use to add new organization
     *
     * @param array $requestedData data that want to store
     * @return object of eloquent model
     */
    public function addNewData(array $requestedData): object
    {
        return $this->repository->addNewData($requestedData);
    }


    /**
     * Description : use to update organization by id
     *
     * @param int $id of organization
     * @param array $requestedData that want to update
     * @return object of eloquent model
     */
    public function updateDataById(int $id, array $requestedData): object
    {
        $this->checkData($id);
        return $this->repository->updateDataById($id, $requestedData);
    }


    /**
     * Description : use to delete the organization by id
     *
     * @param int $id of the organization that want to delete
     * @return bool of status delete organization
     */
    public function deleteDataById(int $id): bool
    {
        $this->checkData($id);
        return $this->repository->deleteDataById($id);
    }
}
