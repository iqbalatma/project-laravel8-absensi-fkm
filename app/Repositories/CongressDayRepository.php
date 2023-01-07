<?php

namespace App\Repositories;

use App\Models\CongressDay;

class CongressDayRepository extends BaseRepository
{
    protected  $model;
    public function __construct()
    {
        $this->model = new CongressDay();
    }

    public function getDataByHDay(string $hDay, array $columns = ["*"])
    {
        return $this->model
            ->select($columns)
            ->whereDate("h_day", "=", $hDay)
            ->first();
    }
}
