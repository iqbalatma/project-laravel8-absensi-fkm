<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Assets\AssetResource;
use App\Http\Resources\Assets\AssetResourceCollection;
use App\Services\AssetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetController extends ApiController
{
    private string $responseName = 'Assets';
    private array $responseMessage = [
        'index' => 'Get list assets successfully',
        'show' => 'Get singe asset successfully',
    ];

    public function index(AssetService $service)
    {
        return $this->responseWithResourceCollection(
            new AssetResourceCollection($service->getAllData()),
            $this->responseName,
            $this->responseMessage["index"],
            JsonResponse::HTTP_OK
        );
    }

    public function show(AssetService $service, int $id)
    {
        return $this->responseWithResource(
            new AssetResource($service->getDataById($id)),
            $this->responseName,
            $this->responseMessage["show"],
            JsonResponse::HTTP_OK
        );
    }
}
