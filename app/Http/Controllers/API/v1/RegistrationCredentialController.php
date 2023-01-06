<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Services\RegistrationCredentialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationCredentialController extends ApiController
{

    /**
     * Get list of registration credential
     *
     * @return void
     */
    public function index(RegistrationCredentialService $service): JsonResponse
    {
        return response()->json(["data" => $service->getAllData()]);
    }

    public function store()
    {
    }
}
