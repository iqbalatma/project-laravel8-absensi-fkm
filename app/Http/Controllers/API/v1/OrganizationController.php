<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\Organizations\StoreOrganizationRequest;
use App\Http\Requests\Organizations\UpdateOrganizationRequest;
use App\Http\Resources\Organizations\OrganizationResource;
use App\Http\Resources\Organizations\OrganizationResourceCollection;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;

class OrganizationController extends ApiController
{
    private string $responseName = 'Organizations';
    private array $responseMessage = [
        'index' => 'Get list organization successfully',
        'show' => 'Get organization successfully',
        'store' => 'Add new organization successfully',
        'update' => 'Update organization successfully',
        'destroy' => 'Delete organization successfully',
        'destroy_failed' => 'Delete congress day failed, the data is not exists',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(OrganizationService $service): JsonResponse
    {
        return $this->responseWithResourceCollection(
            new OrganizationResourceCollection($service->getAllData()),
            $this->responseName,
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationService $service, StoreOrganizationRequest $request): JsonResponse
    {
        $stored = $service->addNewData($request->validated());

        return $this->responseWithResource(
            new OrganizationResource($stored),
            $this->responseName,
            $this->responseMessage["store"],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationService $service, int $id): ?JsonResponse
    {
        return $this->responseWithResource(
            new OrganizationResource($service->getDataById($id)),
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
    public function update(OrganizationService $service, UpdateOrganizationRequest $request, int $id): JsonResponse
    {
        $updated = $service->updateDataById($id, $request->validated());

        return $this->responseWithResource(
            new OrganizationResource($updated),
            $this->responseName,
            $this->responseMessage["update"],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationService $service, int $id): JsonResponse
    {
        $service->deleteDataById($id);
        return $this->apiResponse([
            "success" => true,
            "name" => $this->responseName,
            "message" => $this->responseMessage["destroy"]
        ], JsonResponse::HTTP_OK);
    }
}
