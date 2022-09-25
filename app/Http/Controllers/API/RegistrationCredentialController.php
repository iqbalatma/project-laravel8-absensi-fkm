<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\RegistrationCredentialStoreRequest;
use App\Http\Requests\RegistrationCredentialUpdateRequest;
use App\Http\Resources\RegistrationCredentialResource;
use App\Http\Resources\RegistrationCredentialResourceCollection;
use App\Services\RegistrationCredentialService;
use Illuminate\Http\JsonResponse;

class RegistrationCredentialController extends ApiController
{
    private string $responseName = 'Registration Credential';
    private array $responseMessage = [
        'index'  => 'Get list registration credential successfully',
        'show'  => 'Get single registration credential successfully',
        'store' => 'Store registration credential successfuly',
        'update' => 'Update registration credential successfuly',
    ];


    /**
     * Description : get all registration credential service
     * 
     * @param RegistrationCredentialService $service for execute logic
     * @return JsonResponse for response api
     */
    public function index(RegistrationCredentialService $service):JsonResponse
    {
        $totalPerPage = request()->get('total_per_page') ?? null;
        $allData =  $service->getAll($totalPerPage);

        return $this->responseWithResourceCollection(
            new RegistrationCredentialResourceCollection($allData), 
            $this->responseName, 
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK);
    }


    /**
     * Description : to add new registration credential
     * 
     * @param RegistrationCredentialService $service or execute logic
     * @param RegistrationCredentialStoreRequest $request for validate request
     * @return JsonResponse for response api
     */
    public function store(RegistrationCredentialService $service, RegistrationCredentialStoreRequest $request): JsonResponse
    {
        $storedData = $service->store($request->validated());
        
        return $this->responseWithResource(
            new RegistrationCredentialResource($storedData), 
            $this->responseName, 
            $this->responseMessage['store'],
            JsonResponse::HTTP_CREATED);
    }


    /**
     * Description : use to get registration credential by id
     * 
     * @param RegistrationCredentialService $service for execute logic
     * @param int $id of registration credential
     * @return JsonResponse for user
     */
    public function show(RegistrationCredentialService $service,int $id):JsonResponse
    {
        $data = $service->showById($id);
                
        return $this->responseWithResource(
            new RegistrationCredentialResource($data),
            $this->responseName,
            $this->responseMessage['show'],
            JsonResponse::HTTP_OK);
    }

    /**
     * Description : use to get registration credential by id
     * 
     * @param RegistrationCredentialService $service for execute logic
     * @param int $id of registration credential
     * @return JsonResponse for user
     */
    public function showByToken(RegistrationCredentialService $service, string $token):JsonResponse
    {
        $data = $service->showByToken($token);
                
        return $this->responseWithResource(
            new RegistrationCredentialResource($data),
            $this->responseName,
            $this->responseMessage['show'],
            JsonResponse::HTTP_OK);
    }


    /**
     * Description : update the registration credential 
     * 
     * @param RegistrationCredentialService $service for execute logic
     * @param RegistrationCredentialUpdateRequest $request for validate user
     * @param int $id of the credential update request
     * @return JsonResponse for the user response
     */
    public function update(RegistrationCredentialService $service, RegistrationCredentialUpdateRequest $request, int $id): JsonResponse
    {
        $updated = $service->update($id, $request->validated());

        return $this->responseWithResource(
            new RegistrationCredentialResource($updated),
            $this->responseName,
            $this->responseMessage['update'],
            JsonResponse::HTTP_OK);
    }


    /**
     * Description : use to delete the registration credential by id
     * 
     * @param RegistrationCredentialService $service for execute logic
     * @param int $id of registration credential
     * @return JsonResponse for api response
     */
    public function destroy(RegistrationCredentialService $service, int $id):JsonResponse
    {
        $deleted = $service->destroy($id);
        
        if($deleted)
            return $this->apiResponse([
                'success'=> true,
                'name' => $this->responseName,
                'message' => 'Delete registration credential successfully',
            ],JsonResponse::HTTP_OK);

        return $this->apiResponse([
            'success'=> false,
            'name' => $this->responseName,
            'message' => 'Delete registration credential failed, the data is not exists',
            'error_code' => 404
        ],JsonResponse::HTTP_NOT_FOUND);
    }
}
