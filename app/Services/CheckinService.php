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


  public function index():object
  {
    return $this->checkinStatusModel->all();
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
  public function isPersonalTokenValid(string $personalToken):bool
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
  public function isCongressDayExist(int $congressDayId):bool
  {
    $congressDay = $this->congressDayModel->where('id', $congressDayId)->first();
    if($congressDay){
      return true;
    }
    return false;
  }

  public function setDataUser(object $dataUser):void
  {
    $this->dataUser = $dataUser;
  }

  public function getDataUser()
  {
    return $this->dataUser;
  }
}

?>