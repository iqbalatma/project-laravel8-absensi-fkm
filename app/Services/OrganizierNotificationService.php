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
   * Description : use to get latest notification
   * 
   * @return object of eloquent
   */
  public function getLatestData():object
  {
    return (new OrganizierNotificationRepository())->getLatestNotification();
  }


  /**
   * Description : use to add new notification
   * 
   * @param array $requestedData to store new notification
   * @return object of eloquent
   */
  public function store(array $requestedData):object
  {
    return (new OrganizierNotificationRepository())->storeNewNotification($requestedData);
  }
  
}
?>