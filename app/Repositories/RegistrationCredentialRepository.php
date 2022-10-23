<?php 

namespace App\Repositories;

use App\Exceptions\EmptyDataException;
use App\Models\RegistrationCredential;
use Illuminate\Support\Facades\DB;

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

  public function updateRegistrationCredential(int $id, array $requestedData):?object
  {
    $data = null;
    DB::transaction(function () use ($id, $requestedData, &$data)
    {
      $updated = RegistrationCredential::where('id', $id)->update($requestedData);
      if (!$updated) throw new EmptyDataException();
      $data = RegistrationCredential::find($id);
    });

    return $data;
  }
}
