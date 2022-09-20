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
    private RegistrationCredentialService $registrationCredentialService;
    private string $responseName = 'Registration Credential';
    private array $responseMessage = [
        'index'  => 'Get list registration credential successfully',
        'show'  => 'Get single registration credential successfully',
        'store' => 'Store registration credential successfuly',
        'update' => 'Update registration credential successfuly',
    ];

    public function __construct(RegistrationCredentialService $registrationCredentialService)
    {
        $this->registrationCredentialService = $registrationCredentialService;
    }

    /**
     * Description : get all registration credential service
     * 
     * @return JsonResponse for response api
     */
    public function index():JsonResponse
    {
        $allData =  $this->registrationCredentialService->getAll();

        return $this->responseWithResourceCollection(new RegistrationCredentialResourceCollection($allData), $this->responseName, $this->responseMessage['index'], 200);
    }




    /**
     * Description : to add new registration credential
     * 
     * @param RegistrationCredentialStoreRequest $request for validate request
     * @return JsonResponse for response api
     */
    public function store(RegistrationCredentialStoreRequest $request): JsonResponse
    {
        $storedData = $this->registrationCredentialService->store($request->validated());
        
        return $this->responseWithResource(new RegistrationCredentialResource($storedData), $this->responseName, $this->responseMessage['store'], 201);
    }


    /**
     * Description : use to get registration credential by id
     * 
     * @param int $id of registration credential
     * @return JsonResponse for user
     */
    public function show(int $id):JsonResponse
    {
        $data = $this->registrationCredentialService->show($id);
                
        return $this->responseWithResource(new RegistrationCredentialResource($data), $this->responseName,$this->responseMessage['show'] , 200);
    }


    /**
     * Description : update the registration credential 
     * 
     * @param RegistrationCredentialUpdateRequest $request for validate user
     * @param int $id of the credential update request
     * @return JsonResponse for the user response
     */
    public function update(RegistrationCredentialUpdateRequest $request, int $id): JsonResponse
    {
        $updated = $this->registrationCredentialService->update($id, $request->validated());

        return $this->responseWithResource(new RegistrationCredentialResource($updated),$this->responseName, $this->responseMessage['update'], 200);
    }


    /**
     * Description : use to delete the registration credential by id
     * 
     * @param int $id of registration credential
     * @return JsonResponse for api response
     */
    public function destroy(int $id):JsonResponse
    {
        $deleted = $this->registrationCredentialService->destroy($id);
        
        if($deleted){
            return $this->apiResponse([
                'success'=> true,
                'name' => $this->responseName,
                'message' => 'Delete registration credential successfully',
            ],200);
        }

        return $this->apiResponse([
            'success'=> false,
            'name' => $this->responseName,
            'message' => 'Delete registration credential failed, the data is not exists',
            'error_code' => 404
        ],404);
    }
}
