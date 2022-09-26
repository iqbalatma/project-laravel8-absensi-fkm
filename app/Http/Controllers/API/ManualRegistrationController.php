<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\ManualRegistrationStoreRequest;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;

class ManualRegistrationController extends ApiController
{
    public function manualRegistration(RegistrationService $service, ManualRegistrationStoreRequest $request):JsonResponse
    {
        $stored = $service->manualRegistration($request->validated());

        return $this->apiResponse([
            'success' => true,
            'name' => "Registration",
            'message' => "Manual registration user successfully",
            'result' => [
                'user'=> $stored
            ]
        ],JsonResponse::HTTP_OK);
    }
}
