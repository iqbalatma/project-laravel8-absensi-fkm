<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\CongressDay;
use Illuminate\Support\Facades\DB;

class CongressDayService{
  /**
   * Description : use to get list data of congress day
   * 
   * @return object
   */
  public function getAllData(?int $totalPerPage):object
  {
    $data = empty($totalPerPage) ? CongressDay::all(): CongressDay::paginate($totalPerPage);
    return $data;
  }


  /**
   * Description : use to get single data of congress day by id
   * 
   * @param int $id of congress day
   * @return object
   */
  public function getById(int $id):object
  {
    $data = CongressDay::find($id);
    if (empty($data)){
      throw new EmptyDataException();
    } 
    
    return $data;
  }


  /**
   * Description : Use for add new congress day 
   * 
   * @param array $requestedData
   * @return object
   */
  public function store(array $requestedData): object
  {
    return CongressDay::create($requestedData);
  }


  /**
   * Description : use to update congress day 
   * 
   * @param int $id of congress day
   * @param array $reuqestedData that already validated
   */
  public function update(int $id, array $requestedData)
  {
    DB::beginTransaction();
      CongressDay::where('id',$id)->update($requestedData);
      $updated = CongressDay::find($id);
    DB::commit();

    if (!$updated){
      throw new EmptyDataException();
    } 

    return $updated;
  }


  /**
   * Description : Service for soft delete congress day
   * 
   * @param int $id of congress day
   * @return bool status of deletion
   */
  public function destroy(int $id):bool
  {
    $congressDay = CongressDay::find($id);
    if($congressDay){
      return $congressDay->delete();
    }

    return false;
  }
}
?>