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
    private string $responseName = 'Checkin Status';
    private array $responseMessage = [
        'index' => 'Get list checkin status successfully',
        'checkin'=>'Checkin user successfully',
        'checkout'=>'Checkout user successfully',
    ];


    /**
     * Description : use for checkin or checkout user
     * 
     * @param CheckinService $service for execute logic
     * @param CheckinStatusStoreRequest $request for validation request
     * @param string $personalToken of user checkin
     * @return JsonResponse for json response
     */
    public function checkin(CheckinService $service, CheckinStatusStoreRequest $request, string $personalToken): JsonResponse
    {
        $checkinStatus = $service->checkin($personalToken, $request->validated());

        if ($checkinStatus == Status::INVALID_TOKEN)
            throw new RequestErrorException("Your personal token is invalid", 404);


        if ($checkinStatus == Status::EMTPY_DATA)
            throw new RequestErrorException("Congress day does not exists", 404);

        if ($checkinStatus == Status::CHECKIN_SUCCESS) {
            return $this->apiResponse([
                'success'   => true,
                'name'      => $this->responseName,
                'message'   => $this->responseMessage['checkin']
            ], JsonResponse::HTTP_OK);
        }

        return $this->apiResponse([
            'success'   => true,
            'name'      => $this->responseName,
            'message'   => $this->responseMessage['checkout']
        ], JsonResponse::HTTP_OK);
    }


    /**
     * Description : use to get data checkin status 
     * 
     * @param CheckinService $service for execute logic
     * @return JsonResponse for api response
     */
    public function index(CheckinService $service): JsonResponse
    {
        $totalPerpage = request()->get('total_per_page')??null;
        $data = $service->getAll($totalPerpage, request()->only(
            'checkin_status',
            'congress_day_id',
            'role_id',
            'generation',
            'organization_id'));

        return $this->responseWithResourceCollection(
            new CheckinStatusResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            200);
    }
}
