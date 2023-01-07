<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkin\CheckinRequest;
use App\Services\CheckinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
