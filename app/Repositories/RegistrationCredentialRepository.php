<?php 

namespace App\Repositories;

use App\Models\RegistrationCredential;

class RegistrationCredentialRepository{

  /**
   * Description : use to add registration credential using eloquent
   * 
   * @param array $requestedData that want to add into table
   * @return object of eloquent instance
   */
  public function addNewRegistrationCredential(array $requestedData):object
  {
    return RegistrationCredential::create($requestedData);
  }
}
