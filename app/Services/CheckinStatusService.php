<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\CheckinStatus;
use App\Repositories\CheckinStatusRepository;
use App\Repositories\CongressDayRepository;
use App\Statics\Table;

class CheckinStatusService extends BaseService
{
    private const CHECKIN_STATUS_SELECT_COLUMN = [
        Table::CHECKIN_STATUS . ".id",
        Table::USER . ".name",
        Table::USER . ".email",
        Table::USER . ".student_id",
        Table::USER . ".generation",
        Table::USER . ".phone_number",
        Table::ORGANIZATION . ".name as organization_name",
        Table::CHECKIN_STATUS . ".checkin_status",
        Table::CHECKIN_STATUS . ".checkin_role",
        Table::CHECKIN_STATUS . ".last_checkin_time",
        Table::CHECKIN_STATUS . ".last_checkout_time",
        Table::CHECKIN_STATUS . ".created_at",
    ];

    private const SEARCHABLE_COLUMN = [
        "organization_name" => Table::ORGANIZATION . ".name",
        "checkin_status" => Table::CHECKIN_STATUS . ".checkin_status",
        "name" => Table::USER . ".name",
        "email" => Table::USER . ".email",
        "student_id" => Table::USER . ".student_id",
        "generation" => Table::USER . ".generation",
        "phone_number" => Table::USER . ".phone_number",
    ];
    protected  $repository;

    public function __construct()
    {
        $this->repository = new CheckinStatusRepository();
    }

    public function getAllDataPaginated(): ?object
    {
        $data = $this->repository
            ->searchColumn(self::SEARCHABLE_COLUMN)
            ->getAllDataPaginated(self::CHECKIN_STATUS_SELECT_COLUMN);
        if ($data->count() == 0) {
            throw new EmptyDataException();
        }

        return $data;
    }

    /**
     * Description : use to get all data latest checkin user
     *
     * @return object eloquent object model
     */
    public function getLatestCheckinUser(): object
    {
        $data = CheckinStatus::with(['user' => function ($q) {
            $q->select('id', 'name', 'role_id', 'organization_id')->with(['organization' => function ($subQ) {
                $subQ->select('id', 'name', 'shortname');
            }]);
        }])
            ->select('id', 'last_checkin_time', 'user_id')
            ->limit(4)
            ->orderBy('last_checkin_time', 'desc')
            ->get();

        return $data;
    }
}
