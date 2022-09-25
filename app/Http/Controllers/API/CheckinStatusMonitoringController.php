<?php

namespace App\Http\Controllers\API;

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

    /**
     * Description : use to get data summary on checkin status
     * 
     * @param CheckinStatusMonitoringService $service for execute logic
     * @return JsonResponse for response api
     */
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
        return $this->apiResponse($data, JsonResponse::HTTP_OK);
    }



    /**
     * Description : use to get latest 4 data checkin data 
     * 
     * @param CheckinStatusMonitoringService $service for execute logic
     * @param JsonResponse for response api
     */
    public function getLatest(CheckinStatusMonitoringService $service):JsonResponse
    {
        $data = $service->getLatestCheckinUser();
        return $this->responseWithResourceCollection(
            new CheckinStatusResourceCollection($data),
            $this->responseName,
            $this->responseMessage['latest'],
            JsonResponse::HTTP_OK);
    }
}
