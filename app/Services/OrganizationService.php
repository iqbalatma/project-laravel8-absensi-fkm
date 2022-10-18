<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\Organization;
use App\Repositories\OrganizationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrganizationService{
  /**
   * Description : use to get all data organization
   * 
   * @return object of eloquent model
   */
  public function getAllData():object
  {
    return (new OrganizationRepository())->getAllOrganization();
  }


  /**
   * Description : use to get organization by id
   * 
   * @param int $id of organization
   * @return object of eloquent model
   */
  public function getDataById(int $id):object
  {
    $data = (new OrganizationRepository())->getOrganizationById($id);
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
    return (new OrganizationRepository())->addNewOrganization($requestedData);
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
    $updated = (new OrganizationRepository())->updateOganizationById($id, $requestedData);

    if (!$updated) {
      throw new EmptyDataException();
    }

    return $updated;
  }


  /**
   * Description : use to delete the organization by id
   * 
   * @param int $id of the organization that want to delete
   * @return bool of status delete organization
   */
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