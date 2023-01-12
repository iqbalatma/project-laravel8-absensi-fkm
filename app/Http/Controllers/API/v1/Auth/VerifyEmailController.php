<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\v1\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends ApiController
{


    public function resend(Request $request): JsonResponse
    {
        $request->user()->sendEmailVerificationNotification();

        return $this->apiResponse([
            "success" => true,
            "name" => "Email verification",
            "message" => "Resend email verification successfully",
        ], JsonResponse::HTTP_OK);
    }

    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return $this->apiResponse([
            "success" => true,
            "name" => "Email verification",
            "message" => "Email verification successfully"
        ], JsonResponse::HTTP_OK);
    }
}
