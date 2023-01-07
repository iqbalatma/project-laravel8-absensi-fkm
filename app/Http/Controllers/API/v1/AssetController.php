<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\Assets\AssetResource;
use App\Http\Resources\Assets\AssetResourceCollection;
use App\Services\AssetService;
use Illuminate\Http\JsonResponse;

class AssetController extends ApiController
{
    private string $responseName = 'Assets';
    private array $responseMessage = [
        'index' => 'Get list assets successfully',
        'show' => 'Get singe asset successfully',
    ];

    public function index(AssetService $service): JsonResponse
    {
        return $this->responseWithResourceCollection(
            new AssetResourceCollection($service->getAllData()),
            $this->responseName,
            $this->responseMessage["index"],
            JsonResponse::HTTP_OK
        );
    }

    public function show(AssetService $service, int $id): JsonResponse
    {
        return $this->responseWithResource(
            new AssetResource($service->getDataById($id)),
            $this->responseName,
            $this->responseMessage["show"],
            JsonResponse::HTTP_OK
        );
    }

    public function download(AssetService $service, int $id)
    {
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        list(
            'path' => $path,
            'filename' => $filename
        ) = $service->downloadById($id);

        return response()->download($path, $filename, $headers);
    }
}
