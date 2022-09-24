<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\User;

class UserService{

  /**
   * Description : use to get all data user
   * 
   * @return object eloquent model
   */
  public function getAll(array $requestedData, ?int $totalPerPage):object
  {
    $whereClause = [];
    if(isset($requestedData['role_id']))
      $whereClause['role_id'] = $requestedData['role_id'];
    

    if(isset($requestedData['generation'])) 
      $whereClause['generation'] = $requestedData['generation'];

    if(isset($requestedData['organization_id'])) 
      $whereClause['organization_id'] = $requestedData['organization_id'];

    $data = User::with('organization')
      ->where($whereClause)
      ->where('role_id', '!=', 1)
      ->where('role_id', '!=', 2);
      
    $data = empty($totalPerPage) ? 
      $data->get():
      $data->paginate($totalPerPage);

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

  /**
   * Description : use to update the requested data by id
   * 
   * @param int $id of user
   * @param array $requestedData that want to update
   */
  public function update(int $id,array $requestedData)
  {
    User::where('id', $id)->update($requestedData);
    return User::find($id);
  }
}
?>