<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CongressDayStoreRequest;
use App\Http\Requests\CongressDayUpdateRequest;
use App\Http\Resources\CongressDayResource;
use App\Http\Resources\CongressDayResourceCollection;
use App\Services\CongressDayService;
use Illuminate\Http\JsonResponse;

class CongressDayController extends ApiController
{
    private string $responseName = 'Congress Day';
    private array $responseMessage = [
        'index'=>'Get list data congress day successfully',
        'show'=>'Get single congress day successfully',
        'store' => 'Store new congress day successfully',
        'update'=> 'Update congress day successfully'
    ];

    /**
     * Description : for get data list of congress day
     * 
     * @param CongressDayService $service for execute logic
     * @return JsonResponse for api response
     */
    public function index(CongressDayService $service):JsonResponse
    {
        $totalPerPage = request()->get('total_per_page') ?? null;
        $data = $service->getAllData($totalPerPage);

        return $this->responseWithResourceCollection(
            new CongressDayResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK);
    }


    /**
     * Description : to get single congress day
     * 
     * @param CongressDayService $service for execute logic
     * @param integer $id of the congress day
     * @return JsonResponse resource for response
     */
    public function show(CongressDayService $service,int $id):JsonResponse
    {
        $data = $service->getById($id);

        return $this->responseWithResource(
            new CongressDayResource($data),
            $this->responseName, 
            $this->responseMessage['show'],
            JsonResponse::HTTP_OK);
    }

    /**
     * Description : to store data congress day
     * 
     * @param CongressDayStoreRequest $request for validate the request
     * @return JsonResponse for response 
     */
    public function store(CongressDayService $service, CongressDayStoreRequest $request):JsonResponse
    {
        $stored = $service->store($request->validated());

        return $this->responseWithResource(
            new CongressDayResource($stored),
            $this->responseName, 
            $this->responseMessage['show'],
            JsonResponse::HTTP_CREATED);
    }


    /**
     * Description : for update the congress day 
     * 
     * @param CongressDayUpdateRequest $request for validate the request
     * @param integer $id the id that want to update
     * @return JsonResponse for response
     */
    public function update(CongressDayService $service, CongressDayUpdateRequest $request, $id):JsonResponse
    {
        $updated = $service->update($id, $request->validated());

        return $this->responseWithResource(
            new CongressDayResource($updated),
            $this->responseName,
            $this->responseMessage['update'],
            JsonResponse::HTTP_OK);
    }


    /**
     * Descriptopm : use for delete congress day data
     * 
     * @param int $id of the congress day
     * @return JsonResposne for api response
     */
    public function destroy(CongressDayService $service, int $id):JsonResponse
    {
        $deleted = $service->destroy($id);

        if($deleted){
            return $this->apiResponse([
                'success'=> true,
                'name' => $this->responseName,
                'message' => 'Delete congress day successfully',
            ],JsonResponse::HTTP_OK);
        }

        return $this->apiResponse([
            'success'=> false,
            'name' => $this->responseName,
            'message' => 'Delete congress day failed, the data is not exists',
            'error_code' => JsonResponse::HTTP_NOT_FOUND
        ],JsonResponse::HTTP_NOT_FOUND);
    }
}
