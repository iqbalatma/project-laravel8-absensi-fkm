<?php 
namespace App\Services;

use App\Repositories\AssetRepository;

class AssetService{
  
  /**
   * Description : use to get all data asset
   * 
   * @return object of eloquent
   */
  public function getAllData():object
  {
    return (new AssetRepository())->getAllAsset();
  }


  /**
   * Description : use to get data by id
   * 
   * @param int $id of asset that want to get
   * @return object of eloquent
   */
  public function getDataById(int $id):object
  {
    return (new AssetRepository())->getAssetById($id);
  }
}
?>