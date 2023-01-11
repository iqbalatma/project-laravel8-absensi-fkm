<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\MyProfile\UpdateMyProfileRequest;
use App\Http\Resources\MyProfile\MyProfileResource;
use App\Services\MyProfileService;
use Illuminate\Http\JsonResponse;

class MyProfileController extends ApiController
{
    private string $responseName = "My Profile";
    private array $responseMessage = [
        "show" => "Get my profile successfully",
        "update" => "Update my profile successfully"
    ];
    public function show(MyProfileService $service): JsonResponse
    {
        return $this->responseWithResource(
            new MyProfileResource($service->getDataById()),
            $this->responseName,
            $this->responseMessage["show"],
            JsonResponse::HTTP_OK
        );
    }

    public function update(MyProfileService $service, UpdateMyProfileRequest $request): JsonResponse
    {
        return $this->responseWithResource(
            new MyProfileResource($service->updateDataById($request->validated())),
            $this->responseName,
            $this->responseMessage["update"],
            JsonResponse::HTTP_OK
        );
    }
}
