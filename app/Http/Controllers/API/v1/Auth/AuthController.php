<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\v1\ApiController;
use App\Http\Requests\Auth\AuthenticationRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    /**
     * Login
     * @param AuthService $service
     * @param AuthenticationRequest $request
     * @return JsonResponse
     */
    public function authenticate(AuthService $service, AuthenticationRequest $request): JsonResponse
    {
        return response()
            ->json(
                $service->authenticate($request->validated()),
                JsonResponse::HTTP_OK
            );
    }


    /**
     * Use to refresh new access token
     *
     *
     * @param AuthService $service
     * @return JsonResponse
     */
    public function refresh(AuthService $service): JsonResponse
    {
        return response()
            ->json(
                $service->refresh(),
                JsonResponse::HTTP_OK
            );
    }


    /**
     * Logout the current user token (invalidate the token)
     * @param AuthService $service
     * @return JsonResponse
     */
    public function logout(AuthService $service)
    {
        return response()->json($service->logout(), JsonResponse::HTTP_OK);
    }
}
