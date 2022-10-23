<?php

namespace App\Http\Controllers\API;

use App\Exceptions\RequestErrorException;
use App\Http\Requests\CheckinByCongressDateRequest;
use App\Http\Requests\CheckinStatusStoreRequest;
use App\Http\Resources\CheckinStatusResourceCollection;
use App\Http\Status;
use App\Models\CheckinStatus;
use App\Models\User;
use App\Repositories\CheckinRepository;
use App\Services\CheckinService;
use Illuminate\Http\JsonResponse;

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
     * @deprecated
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
     * Description : use for checkin or checkout user
     * 
     * @param CheckinService $service for execute logic
     * @param CheckinStatusStoreRequest $request for validation request
     * @param string $personalToken of user checkin
     * @return JsonResponse for json response
     */
    public function checkinByCongressDate(CheckinService $service, CheckinByCongressDateRequest $request, string $personalToken): JsonResponse
    {
        // $user = User::where('personal_token', $personalToken)->first();
        // $organizationId = $user->organization_id;
        // $data = CheckinStatus::whereHas('user',function ($query) use($organizationId){
        //     return $query->where(['organization_id'=> $organizationId,'role_id'=>3]);
        //    })->where(['congress_day_id'=> 1])->get();

           
        // // $data = (new CheckinRepository())->getCheckinOrganizationParticipantNumber(1,10);

        // return response()->json(['data'=> $user->role]);

        $checkinStatus = $service->checkinByCongressDate($personalToken, $request->validated());
        if ($checkinStatus == Status::INVALID_TOKEN)
            throw new RequestErrorException("Your personal token is invalid", JsonResponse::HTTP_FORBIDDEN);


        if ($checkinStatus == Status::EMTPY_DATA)
            throw new RequestErrorException("Congress day does not exists", JsonResponse::HTTP_NOT_FOUND);

        if ($checkinStatus == Status::REACH_THE_LIMIT)
            throw new RequestErrorException("Checkin as participan has reach out the limit", JsonResponse::HTTP_FORBIDDEN);



        #NOTES INI HARUS DIPERBAIKI JANGAN SIMPAN DISINI !
        $user = User::with('organization')->where('personal_token', $personalToken)->first();

        if ($checkinStatus == Status::CHECKIN_SUCCESS) {
            return $this->apiResponse([
                'success'   => true,
                'name'      => $this->responseName,
                'message'   => $this->responseMessage['checkin'],
                'result'    => [
                    'data' => $user
                ]
            ], JsonResponse::HTTP_OK);
        }
        return $this->apiResponse([
            'success'   => true,
            'name'      => $this->responseName,
            'message'   => $this->responseMessage['checkout'],
            'result'    => [
                'data' => $user
            ]
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
        $data = $service->getAllData($totalPerpage, request()->only(
            'checkin_status',
            'congress_day_id',
            'congress_date',
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
