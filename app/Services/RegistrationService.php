<?php 

namespace App\Services;

use App\Exceptions\InvalidRegistrationCredential;
use App\Models\RegistrationCredential;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class RegistrationService {
  const INVALID_TOKEN = 404;
  private object $registrationCredential;
  public function register(string $registrationCredentialToken, array $requestedData)
  {
    if(!$this->checkRegistrationCredential($registrationCredentialToken)){
      return self::INVALID_TOKEN;
    }

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

  private function setRegistrationCredential(object $registrationCredential):void
  {
    $this->registrationCredential = $registrationCredential;
  }

  private function getRoleId():int
  {
    return $this->registrationCredential->id;
  }

  private function decreaseLimitRegistration():void
  {
    $this->registrationCredential->decrement('limit');
  }

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