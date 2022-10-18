<?php 

namespace App\Repositories;

use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class OrganizationRepository{

  private int $defaultPerPage = 15;


  /**
   * Description : use to get all data organization with pagination
   * 
   * @return object of eloquent 
   */
  public function getAllOrganization():object
  {
    return Organization::paginate($this->defaultPerPage);
  }

  /**
   * Description : use to get organization by id
   * 
   * @param int $id of organization
   * @return object of eloquent
   */
  public function getOrganizationById(int $id):object
  {
    return Organization::find($id);
  }

  /**
   * Description : use to add data organization
   * 
   * @param array $requestedData from body request
   * @return object of eloquent
   */
  public function addNewOrganization(array $requestedData):object
  {
    return Organization::create($requestedData);
  }


  /**
   * Description : use to update organization by id
   * 
   * @param int $id of organization
   * @param array $requestedData from body request
   * @return object of eloquent
   */
  public function updateOganizationById(int $id, array $requestedData):?object
  {
    $updated = null;
    DB::transaction(function () use ($id, $requestedData, &$updated)
    {
      Organization::where('id', $id)->update($requestedData);
      $updated = Organization::find($id);
    });

    return $updated;
  }
}
