<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\CongressDay;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService{

  /**
   * Description : use to get all data user
   * 
   * @return object eloquent model
   */
  public function getAll(array $requestedData):object
  {
    $whereClause = [];
    if(isset($requestedData['role_id'])) 
      $whereClause['role_id'] = $requestedData['role_id'];

    if(isset($requestedData['generation'])) 
      $whereClause['generation'] = $requestedData['generation'];

    $data = User::where($whereClause)->get();
    

    return $data; 
  }


  /**
   * Description : use to get data user by id
   * 
   * @param int $id of user
   * @return object eleoquent
   */
  public function show(int $id):object
  {
    $data = User::find($id);
    if (empty($data))
      throw new EmptyDataException(); 
    return $data;
  }
}
?>