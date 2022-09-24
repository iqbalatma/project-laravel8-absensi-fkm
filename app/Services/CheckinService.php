<?php 

namespace App\Services;

use App\Http\Status;
use App\Models\CheckinStatus;
use App\Models\CongressDay;
use App\Models\User;

class CheckinService{

  private CheckinStatus $checkinStatusModel;
  private CongressDay $congressDayModel;
  private object $dataUser;
  private User $userModel;
  public function __construct(CheckinStatus $checkinStatusModel, User $userModel, CongressDay $congressDayModel) {
    $this->checkinStatusModel = $checkinStatusModel;
    $this->userModel = $userModel;
    $this->congressDayModel = $congressDayModel;
  }


  /**
   * Description : get all data checkin status
   * 
   * @param array $requestedData for query param
   * @return object of eloquent model
   */
  public function getAll(?int $totalPerPage, array $requestedData)
  {
    
    $whereClause = [];
    $whereClauseUser = [];
    if(isset($requestedData['congress_day']))
      $whereClause['congress_day_id'] = $requestedData['congress_day'];
    
    if(isset($requestedData['checkin_status']))
      $whereClause['checkin_status'] = $requestedData['checkin_status'];
    
    if(isset($requestedData['role_id']))
      $whereClauseUser['role_id'] = $requestedData['role_id'];

    if(isset($requestedData['generation']))
      $whereClauseUser['generation'] = $requestedData['generation'];

    if(isset($requestedData['organization_id']))
      $whereClauseUser['organization_id'] = $requestedData['organization_id'];

    $data = CheckinStatus::whereHas('user', function($q) use ($whereClauseUser){
        $q->where($whereClauseUser);
      })
      ->with(['user.role', 'user.organization'])
      ->where($whereClause);
      
    $data = empty($totalPerPage) ? 
      $data->get():
      $data->paginate($totalPerPage);


    return $data;
  }

  /**
   * Description : use for checkin the user
   * 
   * @param string $personalToken of the checkin user
   * @param array $requestedData of checkin user
   * @return string status of checkin
   */
  public function checkin(string $personalToken, array $requestedData):int
  {
    if(!$this->isPersonalTokenValid($personalToken)){
      return Status::INVALID_TOKEN;
    }

    if(!$this->isCongressDayExist($requestedData['congress_day_id'])){
      return Status::EMTPY_DATA;
    }
    
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
          $checkinStatus->save();

          return Status::CHECKOUT_SUCCESS;
      }else{ //for checkin user that status is checkout
          $checkinStatus->checkin_status = 1;
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
    $user = $this->userModel->where('personal_token', $personalToken)->first();

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
    $congressDay = $this->congressDayModel->where('id', $congressDayId)->first();
    if($congressDay){
      return true;
    }
    return false;
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