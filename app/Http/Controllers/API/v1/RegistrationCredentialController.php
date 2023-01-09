<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\RegistrationCredentials\StoreRegistrationCredentialRequest;
use App\Http\Requests\RegistrationCredentials\UpdateRegistrationCredentialRequest;
use App\Http\Resources\RegistrationCredentials\RegistrationCredentialResource;
use App\Http\Resources\RegistrationCredentials\RegistrationCredentialResourceCollection;
use App\Models\RegistrationCredential;
use App\Services\RegistrationCredentialService;
use Illuminate\Http\JsonResponse;

class RegistrationCredentialController extends ApiController
{
    private string $responseName = 'Registration Credentials';
    private array $responseMessage = [
        'index'  => 'Get list registration credential successfully',
        'show'  => 'Get single registration credential successfully',
        'showByToken'  => 'Get single registration credential by token successfully',
        'store' => 'Store registration credential successfuly',
        'update' => 'Update registration credential successfuly',
        'destroy' => 'Delete registration credential successfully',
    ];


    /**
     * Get list of registration credential
     *
     * @return JsonResponse
     */
    public function index(RegistrationCredentialService $service): JsonResponse
    {
        return $this->responseWithResourceCollection(
            new RegistrationCredentialResourceCollection($service->getAllDataPaginated()),
            $this->responseName,
            $this->responseMessage["index"],
            JsonResponse::HTTP_OK
        );
    }

    public function store(RegistrationCredentialService $service, StoreRegistrationCredentialRequest $request): JsonResponse
    {
        return $this->responseWithResource(
            new RegistrationCredentialResource($service->addNewData($request->validated())),
            $this->responseName,
            $this->responseMessage["store"],
            JsonResponse::HTTP_CREATED
        );
    }

    public function show(RegistrationCredentialService $service, int $id): JsonResponse
    {
        return $this->responseWithResource(
            new RegistrationCredentialResource($service->getDataById($id)),
            $this->responseName,
            $this->responseMessage["show"],
            JsonResponse::HTTP_OK
        );
    }

    public function showByToken(RegistrationCredentialService $service, string $token): JsonResponse
    {
        return $this->responseWithResource(
            new RegistrationCredentialResource($service->getDataByToken($token)),
            $this->responseName,
            $this->responseMessage["showByToken"],
            JsonResponse::HTTP_OK
        );
    }

    public function update(RegistrationCredentialService $service, UpdateRegistrationCredentialRequest $request, int $id): JsonResponse
    {
        return $this->responseWithResource(
            new RegistrationCredentialResource($service->updateDataById($id, $request->validated())),
            $this->responseName,
            $this->responseMessage["update"],
            JsonResponse::HTTP_OK
        );
    }

    public function destroy(RegistrationCredentialService $service, int $id): JsonResponse
    {
        $service->deleteDataById($id);
        return $this->apiResponse([
            "success" => true,
            "name"    => $this->responseName,
            "message" => $this->responseMessage["destroy"]
        ]);
    }
}
