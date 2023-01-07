<?php

namespace App\Services;

use App\Exceptions\RequestErrorException;
use App\Http\Status;
use App\Models\CheckinStatus;
use App\Models\CongressDay;
use App\Repositories\CheckinRepository;
use App\Repositories\CheckinStatusRepository;
use App\Repositories\CongressDayRepository;
use App\Repositories\UserRepository;
use App\Statics\GlobalStatic;

class CheckinService extends BaseService
{
    private object $dataUser;
    private object $congressDay;
    protected $repository;
    protected $userRepo;
    protected $congressDayRepo;

    public function __construct()
    {
        $this->repository = new CheckinStatusRepository();
        $this->userRepo = new UserRepository();
        $this->congressDayRepo = new CongressDayRepository();
    }


    public function checkin(string $personalToken, array $requestedData): bool
    {
        if (!$this->isPersonalTokenValid($personalToken))
            throw new RequestErrorException("Your personal token is invalid", 404);

        if (!$this->isCongressDateExists($requestedData['congress_date']))
            throw new RequestErrorException("Congress day does not exists", 404);

        $dataUser = $this->getDataUser();
        $dataCongressDay = $this->getDataCongressDay();
        $requestedData['checkin_status'] = true;
        $requestedData['checkin_role'] = $dataUser->role->name ?? "";
        $requestedData['user_id'] = $dataUser->id;
        $requestedData['congress_day_id'] = $dataCongressDay->id;
        $isCheckinAllowed = true;

        if ($dataUser->organization_id) {
            $isCheckinAllowed = $this->isCheckinAllowed($dataCongressDay->id, $dataUser->organization_id);
        }
        // to get user checkin status
        $currentCheckinStatus = $this->repository->getDataByUserIdAndCongressDateId($dataUser->id, $dataCongressDay->id);

        if (empty($currentCheckinStatus)) { //for the user that not checkin yet
            if (!$isCheckinAllowed && $dataUser->role_id == GlobalStatic::ROLE_PARTICIPANT) { //if checkin not allowed and role as participant, make it guest and add new data checkin
                $requestedData['checkin_role'] = 'guest';
            }
            $this->repository->addNewData($requestedData);
            return true;
        } else {
            $currentCheckinStatus->checkin_role = $dataUser->role->name ?? "";
            if ($currentCheckinStatus->checkin_status) { //for checkout the user that already checkin
                $currentCheckinStatus->checkin_status = false;
                $currentCheckinStatus->last_checkout_time = now();
                $currentCheckinStatus->save();
                return false;
            } else { //for checkin user that status is checkout
                if (!$isCheckinAllowed && $dataUser->role_id == GlobalStatic::ROLE_PARTICIPANT) {
                    $currentCheckinStatus->checkin_role = 'guest';
                }
                $currentCheckinStatus->checkin_status = true;
                $currentCheckinStatus->last_checkin_time = now();
                $currentCheckinStatus->save();
                return true;
            }
        }
    }

    /**
     * Description : Use to check is personal token is valid on user
     *
     * @param string $personalToken of the user that try to checkin
     * @return bool status of validation personal token
     */
    private function isPersonalTokenValid(string $personalToken): bool
    {
        $user = $this->userRepo->getDataByPersonalToken($personalToken);
        if ($user) {
            $this->setDataUser($user);
            return true;
        }
        return false;
    }


    private function isCongressDateExists(string $congressDate): bool
    {
        $congressDay = $this->congressDayRepo->getDataByHDay($congressDate);
        if ($congressDay) {
            $this->setDataCongressDay($congressDay);
            return true;
        }
        return false;
    }

    private function isCheckinAllowed(int $congressDateId, int $organizationId): bool
    {
        $numberOfCheckin = $this->repository->getCheckinOrganizationParticipantNumber($congressDateId, $organizationId);
        if ($numberOfCheckin >= GlobalStatic::PARTICIPANT_CHECKIN_LIMIT) {
            return false;
        }

        return true;
    }



    // /**
    //  * Description : get all data checkin status
    //  *
    //  * @param array $requestedData for query param
    //  * @return object of eloquent model
    //  */
    // public function getAllData(?int $totalPerPage, array $requestedData): object
    // {
    //     $congressDate = false;
    //     if (isset($requestedData['congress_date'])) {
    //         $congressDate = $requestedData['congress_date'];
    //         unset($requestedData['congress_date']);
    //     }
    //     #separate where clause for checkin status table
    //     $whereClause = $requestedData;
    //     unset($whereClause['generation'], $whereClause['role_id'], $whereClause['organization_id']);

    //     #where clause for table user relation
    //     $whereClauseUser = array_diff($requestedData, $whereClause);

    //     $data = CheckinStatus::whereHas('user', function ($q) use ($whereClauseUser) {
    //         $q->where($whereClauseUser);
    //     })
    //         ->with(['user.role', 'user.organization', 'congressday'])
    //         ->where($whereClause);

    //     if ($congressDate) {
    //         $data = $data->whereHas('congressday', function ($q) use ($congressDate) {
    //             $q->whereDate('h_day', '=', $congressDate);
    //         });
    //     }

    //     $data = empty($totalPerPage) ?
    //         $data->get() :
    //         $data->paginate($totalPerPage);


    //     return $data;
    // }

    // /**
    //  * Description : use to checkin manual by user id and congress_day_id
    //  *
    //  * @param array $requestedData that brings data for manual checkin
    //  * @return int for checkin status
    //  */
    // public function manualCheckin(array $requestedData): int
    // {
    //     list('user_id' => $userId, 'congress_day_id' => $congressDayId) = $requestedData;
    //     $checkinStatus = CheckinStatus::where([
    //         'user_id' => $userId,
    //         'congress_day_id' => $congressDayId
    //     ])->first();

    //     if (empty($checkinStatus)) { //for the user that not checkin yet
    //         $requestedData['checkin_status'] = 1;
    //         CheckinStatus::create($requestedData);
    //         return Status::CHECKIN_SUCCESS;
    //     } else {
    //         if ($checkinStatus->checkin_status) { //for checkout the user that already checkin
    //             $checkinStatus->checkin_status = 0;
    //             $checkinStatus->last_checkout_time = now();
    //             $checkinStatus->save();
    //             return Status::CHECKOUT_SUCCESS;
    //         } else { //for checkin user that status is checkout
    //             $checkinStatus->checkin_status = 1;
    //             $checkinStatus->last_checkin_time = now();
    //             $checkinStatus->save();
    //             return Status::CHECKIN_SUCCESS;
    //         }
    //     }
    // }


    public function setDataCongressDay(object $dataCongressDay): void
    {
        $this->congressDay = $dataCongressDay;
    }

    public function getDataCongressDay(): object
    {
        return $this->congressDay;
    }

    private function setDataUser(object $dataUser): void
    {
        $this->dataUser = $dataUser;
    }

    private function getDataUser()
    {
        return $this->dataUser;
    }
}
