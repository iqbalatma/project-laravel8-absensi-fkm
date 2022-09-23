<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\RegistrationCredential;
use Illuminate\Support\Str;


class RegistrationCredentialService
{

  private RegistrationCredential $registrationCredentialModel;
  public function __construct()
  {
    $this->registrationCredentialModel = new RegistrationCredential();
  }


  /**
   * Description : Use to get all data of credential service
   * 
   * @param int $totalPerPage is 
   * @return RegistrationCredential of eloquent instance
   */
  public function getAll(?int $totalPerPage): object
  {
    $data = empty($totalPerPage) ? 
      $this->registrationCredentialModel->all():
      $this->registrationCredentialModel->paginate($totalPerPage);

    return $data;
  }


  /**
   * Description : for get registration credential by id
   * 
   * @param integer $id of registration credential
   * @return RegistrationCredential
   */
  public function show(int $id): object
  {
    $data = RegistrationCredential::with('organization', 'role')->find($id);

    if (empty($data))
      throw new EmptyDataException();

    return $data;
  }

  /**
   * Description : for get registration credential by id
   * 
   * @param integer $id of registration credential
   * @return RegistrationCredential
   */
  public function showByToken(string $token): object
  {
    $data = RegistrationCredential::with('organization', 'role')
      ->where('token',$token)
      ->first();

    if (empty($data))
      throw new EmptyDataException();

    return $data;
  }


  /**
   * Description : use to store new data registration credential 
   * 
   * @param array $requestedData to arleady validated
   * @return RegistrationCredential Eloquent instance
   */
  public function store(array $requestedData): object
  {
    $requestedData['is_active'] = 1;
    $requestedData['token'] = Str::random(8);

    return  $this->registrationCredentialModel->create($requestedData);
  }


  /**
   * Description : use to update the registration credential
   * 
   * @param int $id of the credential update request
   * @param array $requestedData is validated request from user
   * @return RegistrationCredential Eloquent instance
   */
  public function update(int $id, array $requestedData): object
  {
    $updated = RegistrationCredential::where('id', $id)->update($requestedData);

    if (!$updated) throw new EmptyDataException();

    $data = RegistrationCredential::find($id);
    return $data;
  }


  /**
   * Description : service for destroy the registration credential
   * 
   * @param int $id of registration credential
   * @return bool if delete is success
   */
  public function destroy(int $id): bool
  {
    $registrationCredential = RegistrationCredential::find($id);
    if($registrationCredential)
      return $registrationCredential->delete();

    return false;
  }
}
