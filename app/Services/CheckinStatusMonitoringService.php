<?php 
namespace App\Services;

use App\Models\CheckinStatus;
use App\Models\User;

class CheckinStatusMonitoringService{

  /**
   * Description : Use for get all data monitoring summary on checkin status
   * 
   * @param 
   */
  public function getAllMonitoringData():array
  {
    $dataCheckinStatus = CheckinStatus::whereHas('user', function($q){
      $q->whereNotIn('role_id', [1,2]);
    })->with('user')->get();
    $dataUser = User::whereNotIn('role_id',[1,2])->get();

    $active = $dataCheckinStatus->where('checkin_status', 1);
    $data =[
      'all_organization_active'=> $active->unique('user.organization_id')->count(),
      'all_active' => $active->count(),
      'all_active_participant' => $active->where('user.role_id', 3)->count(),
      'all_active_guest' => $active->where('user.role_id', 4)->count(),
      'all_active_alumni' => $active->where('user.role_id', 5)->count(),
      'all_registered' => $dataUser->count(),
      'all_user_have_checked_in' => $dataCheckinStatus->count(),
      'all_active_guest_non_organization' => $dataCheckinStatus->where('user.organization_id', null)->count(),
    ];

    return $data;
  }
}
?>