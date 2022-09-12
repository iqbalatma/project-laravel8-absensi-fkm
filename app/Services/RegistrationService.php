<?php 

namespace App\Services;

use App\Models\RegistrationCredential;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class RegistrationService {
  const INVALID_TOKEN = 404;
  private object $registrationCredential;

  /**
   * Description : Use to register the user with registration credential
   * 
   * @param string $registrationCredentialToken for validate is register is allowed
   * @param array $requestedData that already validated
   */
  public function register(string $registrationCredentialToken, array $requestedData)
  {
    if(!$this->checkRegistrationCredential($registrationCredentialToken))
      return self::INVALID_TOKEN;
    

    $requestedData['password'] = Hash::make($requestedData['password']);
    $requestedData['role_id'] = $this->getRoleId();
    $requestedData['personal_token'] = Str::random(16);

    
    $requestedData['organization_id'] = $this->getOrganizationId($requestedData);
    
    $user = User::create($requestedData);
    $token = $user->createToken('auth_token')->plainTextToken;
    $this->decreaseLimitRegistration();
    
    return [
      $user,$token
    ];

  }


  /**
   * Description : Use to check is token valid or not
   * 
   * @param string $registrationCredentialToken 
   * @return bool status of of credential registration token valid or not
   */
  private function checkRegistrationCredential(string $registrationCredentialToken)
  {
    $dataRegistrationCredential = RegistrationCredential::where([
        'token' => $registrationCredentialToken,
        'is_active' => 1
    ])->where('limit', '>', 0)
      ->first();
    if($dataRegistrationCredential){
      $this->setRegistrationCredential($dataRegistrationCredential);
      return true;
    }

    return false;
  }


  /**
   * Description : setter for registration credential
   * 
   * @param object that wan to set
   */
  private function setRegistrationCredential(object $registrationCredential):void
  {
    $this->registrationCredential = $registrationCredential;
  }


  /**
   * Description : to get role id from registration credential
   * 
   * @return int id of 
   */
  private function getRoleId():int
  {
    return $this->registrationCredential->role_id;
  }


  /**
   * Description : use to decrease limit after registration
   * 
   */
  private function decreaseLimitRegistration():void
  {
    $this->registrationCredential->decrement('limit');
    $this->registrationCredential->save();
  }


  /**
   * Description : use to get organization id, from registration credential/form request or null
   * 
   * @param array $requestedData to get data request from api
   * @return int|null 
   */
  private function getOrganizationId($requestedData)
  {
    $organizationId = null;
    if(!empty($this->registrationCredential->organization_id)){
      $organizationId = $this->registrationCredential->organization_id;
    }else{
      if(!empty($requestedData['organization_id'])){
        $organizationId = $requestedData['organization_id'];
      }
    }
    return $organizationId;
  }
}

?>