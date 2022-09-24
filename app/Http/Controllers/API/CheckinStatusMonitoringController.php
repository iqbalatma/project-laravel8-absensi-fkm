<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CheckinStatusResourceCollection;
use App\Services\CheckinStatusMonitoringService;
use Illuminate\Http\JsonResponse;

class CheckinStatusMonitoringController extends ApiController
{
    private string $responseName = 'Monitoring Data Status Checkin';
    private array $responseMessage = [
        'summary' =>'Get monitoring data status checkin successfuly',
        'latest'=>'Get latest checkin user successfuly'
    ];
    public function getSummary(CheckinStatusMonitoringService $service):JsonResponse
    {
        $data = $service->getAllMonitoringData();
        $data =[
            'success'=> true,
            'name'=> $this->responseName,
            'message'=> $this->responseMessage['summary'],
            'result'=>[
                'data'=>$data
            ]
        ];
        return $this->apiResponse($data, 200);
    }


    public function getLatest(CheckinStatusMonitoringService $service):JsonResponse
    {
        $data = $service->getLatestCheckinUser();
        return $this->responseWithResourceCollection(
            new CheckinStatusResourceCollection($data),
            $this->responseName,
            $this->responseMessage['latest'],
            200);
        return response()->json(['data'=>$data]);
    }
}
