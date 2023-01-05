<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\OrganizationRepository;

class OrganizationService
{
    private const ORGANIZATION_SELECT_COLUMN = [
        "id",
        "name",
        "shortname",
        "link_instagram",
        "link_website",
        "created_at",
    ];
    /**
     * Description : use to get all data organization
     *
     * @return object of eloquent model
     */
    public function getAllData(): ?object
    {
        return (new OrganizationRepository())->getAllData(self::ORGANIZATION_SELECT_COLUMN);
    }


    /**
     * Description : use to get organization by id
     *
     * @param int $id of organization
     * @return object of eloquent model
     */
    public function getDataById(int $id): ?object
    {
        $data = (new OrganizationRepository())->getDataById($id, self::ORGANIZATION_SELECT_COLUMN);
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
        return (new OrganizationRepository())->addNewData($requestedData);
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
        $updated = (new OrganizationRepository())->updateDataById($id, $requestedData);

        if (!$updated) {
            throw new EmptyDataException();
        }

        return $updated;
    }


    /**
     * Description : use to delete the organization by id
     *
     * @param int $id of the organization that want to delete
     * @return bool of status delete organization
     */
    public function deleteDataById(int $id): bool
    {
        $deleted = (new OrganizationRepository())->deleteDataById($id);

        return $deleted;
    }
}
