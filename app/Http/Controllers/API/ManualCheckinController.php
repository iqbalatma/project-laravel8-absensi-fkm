<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManualCheckinStoreRequest;
use App\Http\Status;
use App\Services\CheckinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManualCheckinController extends ApiController
{
    private string $responseName = "Manual Checkin";
    private array $responseMessage = [
        'checkin' => 'Manual checkin successfully',
        'checkout' => 'Manual checkout successfully',
    ];
    public function manualCheckin(CheckinService $service, ManualCheckinStoreRequest $request):JsonResponse
    {
        $checkin = $service->manualCheckin($request->validated());

        if($checkin== Status::CHECKIN_SUCCESS){
            return $this->apiResponse([
                'success'   => true,
                'name'      => $this->responseName,
                'message'   => $this->responseMessage['checkin']
            ], JsonResponse::HTTP_OK);
        }

        if($checkin== Status::CHECKOUT_SUCCESS){
            return $this->apiResponse([
                'success'   => true,
                'name'      => $this->responseName,
                'message'   => $this->responseMessage['checkout']
            ], JsonResponse::HTTP_OK);
        }

    }
}
