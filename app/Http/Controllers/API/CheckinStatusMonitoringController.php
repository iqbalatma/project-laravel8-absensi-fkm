<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CheckinStatusMonitoringService;

class CheckinStatusMonitoringController extends ApiController
{
    public function index(CheckinStatusMonitoringService $service)
    {
        $data = $service->getAllMonitoringData();
        $data =[
            'success'=> true,
            'name'=> 'Monitoring Data Status Checkin',
            'message'=> 'Get monitoring data status checkin successfuly',
            'result'=>[
                'data'=>$data
            ]
        ];
        return $this->apiResponse($data, 200);
    }
}
