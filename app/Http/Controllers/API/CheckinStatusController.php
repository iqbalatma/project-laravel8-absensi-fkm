<?php

namespace App\Http\Controllers\API;

use App\Exceptions\RequestErrorException;
use App\Http\Requests\CheckinStatusStoreRequest;
use App\Http\Resources\CheckinStatusResourceCollection;
use App\Http\Status;
use App\Services\CheckinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckinStatusController extends ApiController
{
    private CheckinService $checkinService;
    private string $responseName = 'Checkin Status';
    private array $responseMessage = [
        'index' => 'Get list checkin status successfully'
    ];
    public function __construct(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }
    public function checkin(CheckinStatusStoreRequest $request, string $personalToken): JsonResponse
    {
        $checkinStatus = $this->checkinService->checkin($personalToken, $request->validated());

        if ($checkinStatus == Status::INVALID_TOKEN)
            throw new RequestErrorException("Your personal token is invalid", 404);


        if ($checkinStatus == Status::EMTPY_DATA)
            throw new RequestErrorException("Congress day does not exists", 404);

        if ($checkinStatus == Status::CHECKIN_SUCCESS) {
            return $this->apiResponse([
                'success'   => true,
                'name'      => 'Checkin',
                'message'   => 'Checkin user successfully',
            ], 200);
        }

        return $this->apiResponse([
            'success'   => true,
            'name'      => 'Checkout',
            'message'   => 'Checkout user successfully',
        ], 200);
    }

    public function index(Request $request, CheckinService $checkinService): JsonResponse
    {
        $data = $checkinService->getAll($request->only('checkin_status', 'congress_day'));

        return $this->responseWithResourceCollection(new CheckinStatusResourceCollection($data), $this->responseName, $this->responseMessage['index'], 200);
    }
}
