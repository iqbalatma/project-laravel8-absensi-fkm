<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\OrganizationStoreRequest;
use App\Http\Requests\OrganizationUpdateRequest;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationResourceCollection;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;

class OrganizationController extends ApiController
{
    private string $responseName = 'Oganization';
    private array $responseMessage = [
        'index' => 'Get all organization successfully',
        'show' => 'Get organization successfully',
        'store' => 'Store organization successfully',
        'update' => 'Update organization successfully',
        'destroy' => 'Delete organization successfully',
        'destroy_failed' => 'Delete congress day failed, the data is not exists',
    ];

    /**
     * Description : to get all data organization
     * 
     * @param OrganizationService $service to execute the logic
     * @return JsonResponse for api response
     */
    public function index(OrganizationService $service)
    {
        $data = $service->getAllData();

        return $this->responseWithResourceCollection(
            new OrganizationResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK);
    }


    /**
     * Description : to get data organization by id
     * 
     * @param OrganizationService $service to execute the logic
     * @return JsonResponse for api response
     */
    public function show(OrganizationService $service, int $id):JsonResponse
    {
        $data = $service->getDataById($id);

        return $this->responseWithResource(
            new OrganizationResource($data),
            $this->responseName,
            $this->responseMessage['show'],
            JsonResponse::HTTP_OK);
    }


    /**
     * Description : to add new data organization
     * 
     * @param OrganizationService $service to execute the logic
     * @param OrganizationStoreRequest $request to validate request
     * @return JsonResponse for response api
     */
    public function store(OrganizationService $service, OrganizationStoreRequest $request):JsonResponse
    {
        $stored = $service->store($request->validated());
        
        return $this->responseWithResource(
            new OrganizationResource($stored),
            $this->responseName, 
            $this->responseMessage['store'], 
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Description : use to update organization by id
     * 
     * @param OrganizationService $service for execute the logic
     * @param OrganizationUpdateRequest $request for validation request
     * @param int $id organization id that want to udpate
     * @return JsonResponse for response api
     */
    public function update(OrganizationService $service, OrganizationUpdateRequest $request, int $id):JsonResponse
    {
        $updated = $service->update($id, $request->validated());

        return $this->responseWithResource(
            new OrganizationResource($updated),
            $this->responseName, 
            $this->responseMessage['update'], 
            JsonResponse::HTTP_OK
        );
    }


    /**
     * Description : use for soft delete organization by id
     * 
     * @param OrganizationService $service for execute the logic
     * @param int $id the id of organization
     * @return JsonResponse for api response
     */
    public function destroy(OrganizationService $service, int $id):JsonResponse
    {
        $deleted = $service->destroy($id);
        
        if($deleted){
            return $this->apiResponse([
                'success'=> true,
                'name' => $this->responseName,
                'message' => $this->responseMessage['destroy'],
            ],JsonResponse::HTTP_OK);
        }

        return $this->apiResponse([
            'success'=> false,
            'name' => $this->responseName,
            'message' => $this->responseMessage['destroy_failed'],
            'error_code' => JsonResponse::HTTP_NOT_FOUND
        ],JsonResponse::HTTP_NOT_FOUND);
    }
}
