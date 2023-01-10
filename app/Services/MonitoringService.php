<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\CheckinStatusRepository;

class MonitoringService extends BaseService
{

    protected $repository;

    public function __construct()
    {
        $this->repository = new CheckinStatusRepository();
    }
    /**
     * Description : Use for get all data monitoring summary on checkin status
     *
     * @param array summary of data checkin status
     */
    public function getAllData(): array
    {
        $dataCheckinStatus = $this->repository->getAllDataMonitoring();
        $active = $dataCheckinStatus->where('checkin_status', 1);
        $data = [
            'all_organization_active'           => $active->unique('user.organization_id')->count(),
            'all_active'                        => $active->count(),
            'all_active_participant'            => $active->where('checkin_role', 'participant')->count(),
            'all_active_guest'                  => $active->where('checkin_role', 'guest')->count(),
            'all_active_alumni'                 => $active->where('checkin_role', 'alumni')->count(),
            'all_registered'                    => User::whereNotIn('role_id', [1, 2])->get()->count(),
            'all_user_have_checked_in'          => $dataCheckinStatus->count(),
            'all_active_guest_non_organization' => $dataCheckinStatus->where('user.organization_id', null)->count(),
        ];

        return $data;
    }
}
