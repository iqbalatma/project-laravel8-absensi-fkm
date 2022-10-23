<?php 
namespace App\Services;

use App\Models\CheckinStatus;
use App\Models\User;

class CheckinStatusMonitoringService{

  /**
   * Description : Use for get all data monitoring summary on checkin status
   * 
   * @param array summary of data checkin status
   */
  public function getAllMonitoringData():array
  {
    $dataCheckinStatus = CheckinStatus::whereHas('user', function($q){
      $q->whereNotIn('role_id', [1,2]);
    })->with('user')->get();

    $active = $dataCheckinStatus->where('checkin_status', 1);
    $data =[
      'all_organization_active'           => $active->unique('user.organization_id')->count(),
      'all_active'                        => $active->count(),
      'all_active_participant'            => $active->where('checkin_role', 'participant')->count(),
      'all_active_guest'                  => $active->where('checkin_role', 'guest')->count(),
      'all_active_alumni'                 => $active->where('checkin_role', 'alumni')->count(),
      'all_registered'                    => User::whereNotIn('role_id',[1,2])->get()->count(),
      'all_user_have_checked_in'          => $dataCheckinStatus->count(),
      'all_active_guest_non_organization' => $dataCheckinStatus->where('user.organization_id', null)->count(),
    ];

    return $data;
  }


  /**
   * Description : use to get all data latest checkin user
   * 
   * @return object eloquent object model
   */
  public function getLatestCheckinUser():object
  {
    $data = CheckinStatus::with(['user'=> function($q){
      $q->select('id', 'name','role_id', 'organization_id')->with(['organization'=>function($subQ){
        $subQ->select('id', 'name', 'shortname');
      }]);
    }])
      ->select('id','last_checkin_time', 'user_id')
      ->limit(4)
      ->orderBy('last_checkin_time', 'desc')
      ->get();

    return $data;
  }
}
?>