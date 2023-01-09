<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\CheckinStatusRepository;
use App\Repositories\CongressDayRepository;

class CheckinStatusService extends BaseService
{
    protected  $repository;

    public function __construct()
    {
        $this->repository = new CheckinStatusRepository();
    }
}
