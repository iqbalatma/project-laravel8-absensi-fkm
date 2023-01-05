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
}
