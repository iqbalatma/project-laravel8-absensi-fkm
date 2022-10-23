<?php 

namespace App\Repositories;

use App\Models\CheckinStatus;

class CheckinRepository{

  public function getCheckinOrganizationParticipantNumber(int $congressDateId, int $organizationId)
  {
    $data = CheckinStatus::whereHas('user',function ($query) use($organizationId){
     return $query->where(['organization_id'=> $organizationId,'role_id'=>3]);
    })->where(['congress_day_id'=> $congressDateId, 'checkin_status'=> 1])->get();

    return count($data);
    
  }
}
