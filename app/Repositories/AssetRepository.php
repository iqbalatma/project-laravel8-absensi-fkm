<?php 

namespace App\Repositories;

use App\Models\Asset;

class AssetRepository{

  private int $defaultPerPage = 15;


  /**
   * Description : use to get all data asset with pagination
   * 
   * @return object of eloquent 
   */
  public function getAllAsset():?object
  {
    return Asset::paginate($this->defaultPerPage);
  }

  /**
   * Description : use to get all data asset by id
   * 
   * @param int $id of asset that want to get
   * @return object of eloquent
   */
  public function getAssetById(int $id):?object
  {
    return Asset::find($id);
  }

}
