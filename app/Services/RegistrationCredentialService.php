<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\RegistrationCredential;
use Illuminate\Support\Str;


class RegistrationCredentialService{

  public function __construct()
  {
    $this->registrationCredentialModel = new RegistrationCredential();
  }


  /**
   * Description : Use to get all data of credential service
   * 
   * @return RegistrationCredential of eloquent instance
   */
  public function getAll():RegistrationCredential
  {
    $totalPerPage = request()->get('total_per_page') ?? 5;
    return $this->registrationCredentialModel->paginate($totalPerPage);
  }


  /**
   * Description : for get registration credential by id
   * 
   * @param integer $id of registration credential
   * @return RegistrationCredential
   */
  public function show(int $id): RegistrationCredential
  {
    $data = RegistrationCredential::find($id);

    if(empty($data)) 
      throw new EmptyDataException();

    return $data;
  }


  /**
   * Description : use to store new data registration credential 
   * 
   * @param array $requestedData to arleady validated
   * @return RegistrationCredential Eloquent instance
   */
  public function store(array $requestedData):RegistrationCredential
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
  public function update(int $id, array $requestedData):RegistrationCredential
  {
    $updated = RegistrationCredential::where('id',$id)->update($requestedData);

    if (!$updated) throw new EmptyDataException();

    $data = RegistrationCredential::find($id);
    return $data;
  }
}
