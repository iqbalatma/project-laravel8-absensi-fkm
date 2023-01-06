<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\v1\ApiController;
use App\Http\Requests\Auth\AuthenticationRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiController
{
    public function authenticate(AuthService $service, AuthenticationRequest $request): JsonResponse
    {
        $data = $service->authenticate($request->validated());
        return response()->json($data);
    }
}
