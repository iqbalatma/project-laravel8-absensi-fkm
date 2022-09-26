<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class OrganizationService{
  /**
   * Description : use to get all data organization
   * 
   * @return object of eloquent model
   */
  public function getAllData():object
  {
    return Organization::all();
  }


  /**
   * Description : use to get organization by id
   * 
   * @param int $id of organization
   * @return object of eloquent model
   */
  public function getDataById(int $id):object
  {
    $data =Organization::find($id);
    if (empty($data)) {
      throw new EmptyDataException();
    }
    return $data;
  }


  /**
   * Description : use to add new organization
   * 
   * @param array $requestedData data that want to store
   * @return object of eloquent model
   */
  public function store(array $requestedData):object
  {
    return Organization::create($requestedData);
  }


  /**
   * Description : use to update organization by id
   * 
   * @param int $id of organization
   * @param array $requestedData that want to update
   * @return object of eloquent model
   */
  public function update(int $id, array $requestedData):object
  {
    DB::beginTransaction();
      Organization::where('id', $id)->update($requestedData);
      $updated =Organization::find($id);
    DB::commit();

    if (!$updated) {
      throw new EmptyDataException();
    }
    return $updated;
  }

  public function destroy(int $id):bool
  {
    $organization = $this->getDataById($id);
    if($organization){
      return $organization->delete();
    }

    return false;
  }

}
?>