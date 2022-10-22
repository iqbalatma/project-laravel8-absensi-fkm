<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\CheckinStatus;
use App\Repositories\AssetRepository;
use App\Repositories\CheckinStatusRepository;
use App\Repositories\CongressDayRepository;
use App\Repositories\OrganizierNotificationRepository;

class CheckoutAllUserService{
  
  public function checkoutAllUserByDate(array $requestedData)
  {
    $congressDay = (new CongressDayRepository())->getCongressDayByDate($requestedData['congress_date']);

    if(empty($congressDay)){
      throw new EmptyDataException();
    }

    $congressDayId = $congressDay->id;

    return (new CheckinStatusRepository())->checkoutAllUser($congressDayId);
  }
  
}
?>