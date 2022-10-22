<?php 

namespace App\Repositories;

use App\Models\Asset;
use App\Models\OrganizierNotification;
use Illuminate\Support\Facades\DB;

class OrganizierNotificationRepository{

  private int $defaultPerPage = 15;


  /**
   * Description : use to get all data notifications with pagination
   * 
   * @return object of eloquent 
   */
  public function getAllNotifications():?object
  {
    return OrganizierNotification::paginate($this->defaultPerPage);
  }

  public function getLatestNotification()
  {
    return OrganizierNotification::orderBy('id', 'DESC')->first();
  }

  public function storeNewNotification(array $requestedData)
  {
    return OrganizierNotification::create($requestedData);
  }
}
