<?php 

namespace App\Repositories;

use App\Models\CheckinStatus;
use App\Models\CongressDay;

class CheckinStatusRepository{

  public function checkoutAllUser(int $congressDayId)
  {
    return CheckinStatus::where('congress_day_id', $congressDayId)->update(['checkin_status'=> 0]);
  }
 
}
