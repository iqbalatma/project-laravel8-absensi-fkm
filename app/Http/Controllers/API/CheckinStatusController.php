<?php

namespace App\Http\Controllers\API;

use App\Exceptions\RequestErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckinStatusStoreRequest;
use App\Http\Resources\CheckinStatusResourceCollection;
use App\Models\Checkin;
use App\Models\CheckinStatus;
use App\Models\User;
use App\Services\CheckinService;
use Illuminate\Http\JsonResponse;

class CheckinStatusController extends ApiController
{
    private CheckinService $checkinService;
    private string $responseName = 'Checkin Status';
    private array $responseMessage = [
        'index' => 'Get list checkin status successfully'
    ];
    public function __construct(CheckinService $checkinService) {
        $this->checkinService = $checkinService;
    }
    public function checkin(CheckinStatusStoreRequest $request, string $personalToken): JsonResponse
    {
        $checkinStatus = $this->checkinService->checkin($personalToken, $request->validated());
        if($checkinStatus==='token invalid'){
            throw new RequestErrorException("Your personal token is invalid", 404);
        }
        if($checkinStatus ==='congress day doest exist'){
            throw new RequestErrorException("Congress day does not exists", 404);
        }
        if($checkinStatus==='checkin success'){
            return $this->apiResponse( [
                'success'   => true,
                'name'      => 'Checkin',
                'message'   => 'Checkin user successfully',
            ], 200);
        }

        return $this->apiResponse( [
            'success'   => true,
            'name'      => 'Checkout',
            'message'   => 'Checkout user successfully',
        ], 200);
    }

    // public function index():JsonResponse
    // {
    //     $checkinStatus = $this->checkinService->index();
    //     return response()->json(['data'=>$checkinStatus]);

    //     return $this->responseWithResourceCollection(new CheckinStatusResourceCollection($checkinStatus), $this->responseName, );
    // }
}
