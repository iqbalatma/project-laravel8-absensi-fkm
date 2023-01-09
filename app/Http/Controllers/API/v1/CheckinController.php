<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\Checkin\CheckinRequest;
use App\Http\Requests\Checkin\ManualCheckinRequest;
use App\Services\CheckinService;
use Illuminate\Http\JsonResponse;

class CheckinController extends ApiController
{
    private string $responseName = 'Checkin Status';
    private array $responseMessage = [
        'index' => 'Get list checkin status successfully',
        'checkin' => 'Checkin user successfully',
        'checkout' => 'Checkout user successfully',
    ];
    public function checkin(CheckinService $service, CheckinRequest $request, string $personalToken): JsonResponse
    {
        $data = $service->checkin($personalToken, $request->validated());

        $dataResponse = [
            'success' => true,
            'name'    => $this->responseName,
        ];
        $dataResponse["message"] = $data ? $this->responseMessage["checkin"] : $this->responseMessage["checkout"];

        return $this->apiResponse($dataResponse, JsonResponse::HTTP_OK);
    }

    public function checkinManual(CheckinService $service, ManualCheckinRequest $request): JsonResponse
    {
        $data = $service->manualCheckin($request->validated());

        $dataResponse = [
            'success' => true,
            'name'    => $this->responseName,
        ];
        $dataResponse["message"] = $data ? $this->responseMessage["checkin"] : $this->responseMessage["checkout"];

        return $this->apiResponse($dataResponse, JsonResponse::HTTP_OK);
    }
}
