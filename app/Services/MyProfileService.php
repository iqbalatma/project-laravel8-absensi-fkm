<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\UserRepository;
use App\Statics\Table;
use Illuminate\Support\Facades\Auth;

class MyProfileService extends BaseService
{
    protected $repository;
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

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function getDataById(): object
    {
        $data = $this->repository->getDataById(Auth::id(), self::USER_SELECT_COLUMN);
        if (empty($data)) {
            throw new EmptyDataException();
        }

        return $data;
    }

    public function updateDataById(array $requestedData)
    {
        $this->checkData(Auth::id());
        return $this->repository->updateDataById(Auth::id(), $requestedData);
    }
}
