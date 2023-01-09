<?php

namespace App\Repositories;

use App\Models\CheckinStatus;

class CheckinStatusRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new CheckinStatus();
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
