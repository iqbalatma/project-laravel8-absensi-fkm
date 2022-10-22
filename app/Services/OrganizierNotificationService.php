<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\AssetRepository;
use App\Repositories\OrganizierNotificationRepository;

class OrganizierNotificationService{
  
  /**
   * Description : use to get all data asset
   * 
   * @return object of eloquent
   */
  public function getAllData():object
  {
    return (new OrganizierNotificationRepository())->getAllNotifications();
  }


  /**
   * Description : use to get data by id
   * 
   * @param int $id of asset that want to get
   * @return object of eloquent
   */
  public function getLatestData()
  {
    return (new OrganizierNotificationRepository())->getLatestNotification();
  }
  
}
?>