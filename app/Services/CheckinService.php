<?php 

namespace App\Services;

use App\Http\Status;
use App\Models\CheckinStatus;
use App\Models\CongressDay;
use App\Models\User;
use App\Repositories\CheckinRepository;

class CheckinService{

  private object $dataUser;
  private object $congressDay;

  /**
   * Description : get all data checkin status
   * 
   * @param array $requestedData for query param
   * @return object of eloquent model
   */
  public function getAllData(?int $totalPerPage, array $requestedData):object
  {
    $congressDate = false;
    if(isset($requestedData['congress_date'])){
      $congressDate = $requestedData['congress_date'];
      unset($requestedData['congress_date']);
    }
    #separate where clause for checkin status table
    $whereClause = $requestedData;
    unset($whereClause['generation'], $whereClause['role_id'], $whereClause['organization_id']);

    #where clause for table user relation
    $whereClauseUser = array_diff($requestedData, $whereClause);

    $data = CheckinStatus::whereHas('user', function($q) use ($whereClauseUser){
        $q->where($whereClauseUser);
      })
      ->with(['user.role', 'user.organization', 'congressday'])
      ->where($whereClause);
    
    if($congressDate){
      $data = $data->whereHas('congressday', function ($q) use ($congressDate){
        $q->whereDate('h_day', '=', $congressDate);
      });
    }
      
    $data = empty($totalPerPage) ? 
      $data->get():
      $data->paginate($totalPerPage);


    return $data;
  }

  public function checkinByCongressDate(string $personalToken, array $requestedData)
  {
    if(!$this->isPersonalTokenValid($personalToken)){
      return Status::INVALID_TOKEN;
    }
    if(!$this->isCongressDateExists($requestedData['congress_date'])){
      return Status::EMTPY_DATA;
    }


    $dataUser = $this->getDataUser();
    $requestedData['user_id']= $dataUser->id;
    $requestedData['checkin_status'] = true;
    $requestedData['congress_day_id'] = $this->getDataCongressDay()->id;

    //check limit
    
   

    $checkinStatus = CheckinStatus::where([
      'user_id' => $dataUser->id,
      'congress_day_id' => $this->getDataCongressDay()->id
    ])->first();

    if(empty($dataUser->organization_id)){
      $isCheckinAllowed = true;
    }else{
      $isCheckinAllowed =$this->isCheckinAllowed($this->getDataCongressDay()->id, $dataUser->organization_id);
    }
    
    if (empty($checkinStatus)) { //for the user that not checkin yet
      if(!$isCheckinAllowed && $dataUser->role_id == 3){
        return Status::REACH_THE_LIMIT;
      }
      CheckinStatus::create($requestedData);
      return Status::CHECKIN_SUCCESS;
    } else {
      if($checkinStatus->checkin_status){ //for checkout the user that already checkin
          $checkinStatus->checkin_status = 0;
          $checkinStatus->last_checkout_time = now();
          $checkinStatus->save();
          return Status::CHECKOUT_SUCCESS;
      }else{ //for checkin user that status is checkout
          if(!$isCheckinAllowed && $dataUser->role_id == 3){
            return Status::REACH_THE_LIMIT;
          }
          $checkinStatus->checkin_status = 1;
          $checkinStatus->last_checkin_time = now();
          $checkinStatus->save();
          return Status::CHECKIN_SUCCESS;
      }
    }
  }

  public function isCheckinAllowed(int $congressDateId, int $organizationId):bool
  {
    $numberOfCheckin = (new CheckinRepository())->getCheckinOrganizationParticipantNumber($congressDateId, $organizationId);
    if($numberOfCheckin>=2){
      return false;
    }

    return true;
  }

  /**
   * Description : use for checkin the user
   * 
   * @deprecated
   * @param string $personalToken of the checkin user
   * @param array $requestedData of checkin user
   * @return string status of checkin
   */
  public function checkin(string $personalToken, array $requestedData):int
  {
    if(!$this->isPersonalTokenValid($personalToken))
      return Status::INVALID_TOKEN;
    

    if(!$this->isCongressDayExist($requestedData['congress_day_id']))
      return Status::EMTPY_DATA;
    
    
    $dataUser = $this->getDataUser();
    $requestedData['user_id']= $dataUser->id;
    $requestedData['checkin_status'] = true;

    $checkinStatus = CheckinStatus::where([
      'user_id' => $dataUser->id,
      'congress_day_id' => $requestedData['congress_day_id']
    ])->first();


    if (empty($checkinStatus)) { //for the user that not checkin yet
      CheckinStatus::create($requestedData);
      return Status::CHECKIN_SUCCESS;
    } else {
      if($checkinStatus->checkin_status){ //for checkout the user that already checkin
          $checkinStatus->checkin_status = 0;
          $checkinStatus->last_checkout_time = now();
          $checkinStatus->save();
          return Status::CHECKOUT_SUCCESS;
      }else{ //for checkin user that status is checkout
          $checkinStatus->checkin_status = 1;
          $checkinStatus->last_checkin_time = now();
          $checkinStatus->save();
          return Status::CHECKIN_SUCCESS;
      }
    }
  }


  /**
   * Description : use to checkin manual by user id and congress_day_id
   * 
   * @param array $requestedData that brings data for manual checkin
   * @return int for checkin status
   */
  public function manualCheckin(array $requestedData):int
  {
    list('user_id'=> $userId, 'congress_day_id'=> $congressDayId) = $requestedData;
    $checkinStatus = CheckinStatus::where([
      'user_id' => $userId,
      'congress_day_id' => $congressDayId
    ])->first();

    if (empty($checkinStatus)) { //for the user that not checkin yet
      $requestedData['checkin_status'] = 1;
      CheckinStatus::create($requestedData);
      return Status::CHECKIN_SUCCESS;
    } else {
      if($checkinStatus->checkin_status){ //for checkout the user that already checkin
          $checkinStatus->checkin_status = 0;
          $checkinStatus->last_checkout_time = now();
          $checkinStatus->save();
          return Status::CHECKOUT_SUCCESS;
      }else{ //for checkin user that status is checkout
          $checkinStatus->checkin_status = 1;
          $checkinStatus->last_checkin_time = now();
          $checkinStatus->save();
          return Status::CHECKIN_SUCCESS;
      }
    }

  }


  /**
   * Description : Use to check is personal token is valid on user
   * 
   * @param string $personalToken of the user that try to checkin
   * @return bool status of validation personal token
   */
  private function isPersonalTokenValid(string $personalToken):bool
  {
    $user = User::where('personal_token', $personalToken)->first();

    if($user){
      $this->setDataUser($user);
      return true;
    }
    return false;
  }

  /**
   * Description : use for check is congress day is valid
   * 
   * 
   */
  private function isCongressDayExist(int $congressDayId):bool
  {
    $congressDay = CongressDay::where('id', $congressDayId)->first();
    if($congressDay){
      return true;
    }
    return false;
  }

  /**
   * Description : use for check is congress day is valid
   * 
   * 
   */
  private function isCongressDateExists(string $congressDate):bool
  {
    $congressDay = CongressDay::whereDate('h_day', '=', $congressDate)->first();
    if($congressDay){
      $this->setDataCongressDay($congressDay);
      return true;
    }
    return false;
  }

  public function setDataCongressDay(object $dataCongressDay):void
  {
    $this->congressDay = $dataCongressDay;
  }

  public function getDataCongressDay():object
  {
    return $this->congressDay;
  }

  private function setDataUser(object $dataUser):void
  {
    $this->dataUser = $dataUser;
  }

  private function getDataUser()
  {
    return $this->dataUser;
  }
}

?>