<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\RegistrationCredential;
use App\Repositories\RegistrationCredentialRepository;
use Illuminate\Support\Str;


class RegistrationCredentialService extends BaseService
{
    private const REGISTRATION_CREDENTIAL_SELECT_COLUMN = [
        "id",
        "role_id",
        "organization_id",
        "limit",
        "token",
        "is_active",
    ];
    protected  $repository;
    public function __construct()
    {
        $this->repository = new RegistrationCredentialRepository();
    }
    /**
     * Description : Use to get all data of credential service
     *
     * @return RegistrationCredential of eloquent instance
     */
    public function getAllData(): object
    {
        $data = $this->repository->getAllData(self::REGISTRATION_CREDENTIAL_SELECT_COLUMN);
        if ($data->count() == 0) {
            throw new EmptyDataException();
        }

        return $data;
    }


    /**
     * Description : for get registration credential by id
     *
     * @param int $id of registration credential
     * @return RegistrationCredential
     */
    public function getDataById(int $id): object
    {
        $data = $this->repository->getDataById($id, self::REGISTRATION_CREDENTIAL_SELECT_COLUMN);
        if (empty($data)) throw new EmptyDataException();
        return $data;
    }

    /**
     * Description : for get registration credential by id
     *
     * @param string $token of registration credential
     * @return RegistrationCredential
     */
    public function getDataByToken(string $token): object
    {
        $data = $this->repository->getDataByToken($token, self::REGISTRATION_CREDENTIAL_SELECT_COLUMN);

        if (empty($data)) throw new EmptyDataException();

        return $data;
    }


    /**
     * Description : use to store new data registration credential
     *
     * @param array $requestedData to arleady validated
     * @return RegistrationCredential Eloquent instance
     */
    public function addNewData(array $requestedData): object
    {
        $requestedData['is_active'] = 1;
        $requestedData['token'] = Str::random(8);

        return $this->repository->addNewData($requestedData);
    }


    /**
     * Description : use to update the registration credential
     *
     * @param int $id of the credential update request
     * @param array $requestedData is validated request from user
     * @return RegistrationCredential Eloquent instance
     */
    public function updateDataById(int $id, array $requestedData): object
    {
        $this->checkData($id);

        return $this->repository->updateDataById($id, $requestedData);
    }


    /**
     * Description : service for delete the registration credential
     *
     * @param int $id of registration credential
     * @return bool if delete is success or not
     */
    public function deleteDataById(int $id): int
    {
        $this->checkData($id);
        return $this->repository->deleteDataById($id);
    }
}
