<?php

namespace App\Http\Controllers\API;

use App\Exceptions\EmptyDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CongressDayStoreRequest;
use App\Http\Requests\CongressDayUpdateRequest;
use App\Http\Resources\CongressDayResource;
use App\Http\Resources\CongressDayResourceCollection;
use App\Models\CongressDay;
use App\Services\CongressDayService;
use Illuminate\Http\JsonResponse;

class CongressDayController extends ApiController
{
    private CongressDayService $congressDaySerivce;
    private string $responseName = 'Congress Day';
    private array $responseMessage = [
        'index'=>'Get list data congress day successfully',
        'show'=>'Get single congress day successfully',
        'store' => 'Store new congress day successfully',
        'update'=> 'Update congress day successfully'
    ];

    public function __construct(CongressDayService $congressDayService) {
        $this->congressDaySerivce = $congressDayService;
    }


    /**
     * Description : for get data list of congress day
     * 
     * @param JsonResponse for api response
     */
    public function index():JsonResponse
    {
        $data = $this->congressDaySerivce->index();

        return $this->responseWithResourceCollection(new CongressDayResourceCollection($data), $this->responseName, $this->responseMessage['index'], 200);
    }


    /**
     * Description : to get single congress day
     * 
     * @param integer $id of the congress day
     * @return JsonResponse resource for response
     */
    public function show(int $id):JsonResponse
    {
        $data = $this->congressDaySerivce->show($id);

        return $this->responseWithResource(new CongressDayResource($data),$this->responseName, $this->responseMessage['show'],200);
    }

    /**
     * Description : to store data congress day
     * 
     * @param CongressDayStoreRequest $request for validate the request
     * @return JsonResponse for response 
     */
    public function store(CongressDayStoreRequest $request):JsonResponse
    {
        $stored = $this->congressDaySerivce->store($request->validated());

        return $this->responseWithResource(new CongressDayResource($stored),$this->responseName, $this->responseMessage['show'],201);
    }


    /**
     * Description : for update the congress day 
     * 
     * @param CongressDayUpdateRequest $request for validate the request
     * @param integer $id the id that want to update
     * @return JsonResponse for response
     */
    public function update(CongressDayUpdateRequest $request, $id):JsonResponse
    {
        $updated = $this->congressDaySerivce->update($id, $request->validated());

        return $this->responseWithResource(new CongressDayResource($updated),$this->responseName, $this->responseMessage['update'],200);
    }


    /**
     * Descriptopm : use for delete congress day data
     * 
     * @param int $id of the congress day
     * @return JsonResposne for api response
     */
    public function destroy(int $id):JsonResponse
    {
        $deleted = $this->congressDaySerivce->destroy($id);
        
        if($deleted){
            return $this->apiResponse([
                'success'=> true,
                'name' => $this->responseName,
                'message' => 'Delete congress day successfully',
            ],200);
        }

        return $this->apiResponse([
            'success'=> false,
            'name' => $this->responseName,
            'message' => 'Delete congress day failed, the data is not exists',
            'error_code' => 404
        ],404);
    }
}
