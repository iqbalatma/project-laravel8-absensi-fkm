<?php 

namespace App\Repositories;

use App\Models\CongressDay;

class CongressDayRepository{

  public function getCongressDayByDate(string $date)
  {
    return CongressDay::whereDate('h_day','=', $date)->first();
  }
 
}
