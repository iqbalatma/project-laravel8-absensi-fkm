<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\OrganizationRepository;
use App\Repositories\UserRepository;
use App\Statics\Table;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagementService extends BaseService
{
    private const USER_SELECT_COLUMN = [
        Table::USER . ".id",
        Table::USER . ".name",
        Table::USER . ".personal_token",
        Table::USER . ".email",
        Table::USER . ".student_id",
        Table::USER . ".generation",
        Table::USER . ".phone_number",
        Table::ROLE . ".name as role_name",
        Table::ORGANIZATION . ".name as organization_name",
        Table::ORGANIZATION . ".shortname as organization_shortname",
        Table::USER . ".updated_at",
    ];

    protected $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }


    /**
     * Description : use to get all data users
     *
     * @return object of eloquent model
     */
    public function getAllDataPaginated(): object
    {
        $data = $this->repository->getAllDataPaginated(self::USER_SELECT_COLUMN);
        if ($data->count() == 0) {
            throw new EmptyDataException();
        }

        return $data;
    }


    /**
     * Description : use to get user by id
     *
     * @param int $id of user
     * @return object of eloquent model
     */
    public function getDataById(int $id): object
    {
        $data = $this->repository->getDataById($id, self::USER_SELECT_COLUMN);
        if (empty($data)) {
            throw new EmptyDataException();
        }
        return $data;
    }


    /**
     * Description : use to add new user
     *
     * @param array $requestedData data that want to store
     * @return object of eloquent model
     */
    public function addNewData(array $requestedData): object
    {
        $requestedData["password"] = Hash::make($requestedData["password"]);
        $requestedData["personal_token"] = Str::random(16);

        $user = $this->repository->addNewData($requestedData);
        event(new Registered($user));
        return $user;
    }


    /**
     * Description : use to update user by id
     *
     * @param int $id of user
     * @param array $requestedData that want to update
     * @return object of eloquent model
     */
    public function updateDataById(int $id, array $requestedData): object
    {
        $this->checkData($id);
        return $this->repository->updateDataById($id, $requestedData);
    }


    public function changeActiveStatus(int $id): int
    {
        $this->checkData($id);
        $status = true;
        if ($this->getData()->is_active) {
            $status = false;
        };
        return $this->repository->changeActiveStatusById($id, $status);
    }
}
