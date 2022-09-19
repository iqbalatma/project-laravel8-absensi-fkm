<?php 
namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\CongressDay;
use Illuminate\Support\Facades\DB;

class CongressDayService{
  private CongressDay $congressDay;
  public function __construct(CongressDay $congressDay) {
    $this->congressDay = $congressDay;
  }


  /**
   * Description : use to get list data of congress day
   * 
   * @return object
   */
  public function index():object
  {
    $totalPerPage = request()->get('total_per_page') ?? 5;
    $data = $this->congressDay->paginate($totalPerPage);

    return $data;
  }


  /**
   * Description : use to get single data of congress day by id
   * 
   * @param int $id of congress day
   * @return object
   */
  public function show(int $id):object
  {
    $data =$this->congressDay->find($id);
    if (empty($data)) throw new EmptyDataException();
    
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
    return  CongressDay::create($requestedData);
  }


  /**
   * Description : use to update congress day 
   * 
   * @param int $id of congress day
   * @param array $reuqestedData that already validated
   */
  public function update(int $id, array $requestedData):object
  {
    DB::beginTransaction();
    CongressDay::where('id',$id)->update($requestedData);
    $updated = CongressDay::find($id);
    DB::commit();
    if (empty($updated)) throw new EmptyDataException();

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
    if($congressDay)
      return $congressDay->delete();

    return false;

  }
}
?>