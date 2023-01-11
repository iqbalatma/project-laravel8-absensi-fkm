<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\v1\ApiController;
use App\Http\Requests\Registration\StoreRegistrationRequest;
use App\Http\Resources\Registration\RegistrationResource;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;

class RegistrationController extends ApiController
{
    private string $responseName = "Registration";
    private array $responseMessage = [
        "registrationWithCredential" => "Registration with credential successfully",
    ];

    /**
     * Registration user with credential
     *
     * @param RegistrationService $service
     * @param StoreRegistrationRequest $request
     * @param string $credential
     * @return JsonResponse
     */
    public function registrationWithCredential(RegistrationService $service, StoreRegistrationRequest $request, string $credential)
    {
        return $this->responseWithResource(
            new RegistrationResource($service->registrationWithCredential($credential, $request->validated())),
            $this->responseName,
            $this->responseMessage["registrationWithCredential"],
            JsonResponse::HTTP_CREATED
        );
    }
}
