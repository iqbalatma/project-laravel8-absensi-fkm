<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\v1\ApiController;
use App\Http\Requests\Auth\ResetPasswordLinkRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\ResetPasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends ApiController
{

    public function requestResetLink(ResetPasswordService $service, ResetPasswordLinkRequest $request): JsonResponse
    {
        $data = $service->requestResetLink($request->validated());

        if ($data["success"] == true) {
            return $this->apiResponse($data, JsonResponse::HTTP_OK);
        }
        return $this->apiResponse($data, JsonResponse::HTTP_BAD_REQUEST);
    }

    public function resetPassword(ResetPasswordService $service, ResetPasswordRequest $request)
    {
        $data = $service->resetPassword($request->validated());
        if ($data["success"] == true) {
            return $this->apiResponse($data, JsonResponse::HTTP_OK);
        }
        return $this->apiResponse($data, JsonResponse::HTTP_BAD_REQUEST);
    }
}
