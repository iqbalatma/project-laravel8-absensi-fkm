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
        "registration" => "Registration successfully"
    ];

    public function registration(RegistrationService $service, StoreRegistrationRequest $request): JsonResponse
    {
        return $this->responseWithResource(
            new RegistrationResource($service->registration($request->validated())),
            $this->responseName,
            $this->responseMessage["registration"],
            JsonResponse::HTTP_CREATED
        );
    }
    public function registrationWithCredential(RegistrationService $service, StoreRegistrationRequest $request, string $credential)
    {
        $stored = $service->registrationWithCredential($credential, $request->validated());

        return $this->responseWithResource(
            new RegistrationResource($stored),
            $this->responseName,
            $this->responseMessage["registrationWithCredential"],
            JsonResponse::HTTP_CREATED
        );
    }
}
