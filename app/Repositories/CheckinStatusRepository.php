<?php

namespace App\Repositories;

use App\Exceptions\EmptyDataException;
use App\Models\CheckinStatus;
use App\Statics\GlobalStatic;
use App\Statics\Table;

class CheckinStatusRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new CheckinStatus();
    }


    public function getAllDataPaginated(array $columns = ["*"], int $perPage = self::DEFAULT_PER_PAGE): ?object
    {
        return $this->model
            ->select($columns)
            ->join(Table::USER, Table::USER . ".id", Table::CHECKIN_STATUS . ".user_id")
            ->join(Table::ORGANIZATION, Table::ORGANIZATION . ".id", Table::USER . ".organization_id")
            ->get();
    }

    public function checkoutAllUser(int $congressDayId)
    {
        return $this->model->where("congress_day_id", $congressDayId)->update(["checkin_status" => false]);
    }

    public function getDataByUserIdAndCongressDateId(int $userId, int $congressDateId, array $columns = ["*"])
    {
        return $this->model->where([
            'user_id' => $userId,
            'congress_day_id' => $congressDateId
        ])->first();
    }

    public function getCheckinOrganizationParticipantNumber(int $congressDateId, int $organizationId): int
    {
        $data = $this->model
            ->whereHas('user', function ($query) use ($organizationId) {
                return $query->where(['organization_id' => $organizationId]);
            })
            ->where([
                'congress_day_id' => $congressDateId,
                'checkin_status' => true,
                'checkin_role' => 'participant'
            ])->get();

        return count($data);
    }
}
