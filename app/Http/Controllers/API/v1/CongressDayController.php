<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\CongressDays\StoreCongressDayRequest;
use App\Http\Requests\CongressDays\UpdateCongressDayRequest;
use App\Http\Resources\CongressDays\CongressDayResource;
use App\Http\Resources\CongressDays\CongressDayResourceCollection;
use App\Services\CongressDayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CongressDayController extends ApiController
{
    private string $responseName = 'Congress Day';
    private array $responseMessage = [
        'index' => 'Get list data congress day successfully',
        'show' => 'Get single congress day successfully',
        'store' => 'Store new congress day successfully',
        'update' => 'Update congress day successfully',
        'destroy' => 'Delete congress day successfully',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CongressDayService $service): JsonResponse
    {
        return $this->responseWithResourceCollection(
            new CongressDayResourceCollection($service->getAllData()),
            $this->responseName,
            $this->responseMessage["index"],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCongressDayRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CongressDayService $service, StoreCongressDayRequest $request): JsonResponse
    {
        $stored = $service->addNewData($request->validated());
        return $this->responseWithResource(
            new CongressDayResource($stored),
            $this->responseName,
            $this->responseMessage["store"],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CongressDayService $service, int $id): JsonResponse
    {
        return $this->responseWithResource(
            new CongressDayResource($service->getDataById($id)),
            $this->responseName,
            $this->responseMessage["show"],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CongressDayService $service, UpdateCongressDayRequest $request, int $id): JsonResponse
    {
        $updated = $service->updateDataById($id, $request->validated());
        return $this->responseWithResource(
            new CongressDayResource($updated),
            $this->responseName,
            $this->responseMessage["update"],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CongressDayService $service, int $id): JsonResponse
    {
        $service->deleteDataById($id);
        return $this->apiResponse([
            "success" => true,
            "name" => $this->responseName,
            "message" => $this->responseMessage["destroy"]
        ], JsonResponse::HTTP_OK);
    }
}
