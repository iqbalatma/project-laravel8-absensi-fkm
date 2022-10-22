<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AssetResource;
use App\Http\Resources\AssetResourceCollection;
use App\Services\AssetService;
use Illuminate\Http\JsonResponse;

class AssetController extends ApiController
{
    private string $responseName = 'Assets';
    private array $responseMessage = [
        'index' => 'Get all assets successfully',
        'show' => 'Get asset successfully',
        // 'store' => 'Store organization successfully',
        // 'update' => 'Update organization successfully',
        // 'destroy' => 'Delete organization successfully',
        // 'destroy_failed' => 'Delete congress day failed, the data is not exists',
    ];


    /**
     * Description : use for get all data index
     * 
     * @param AssetService $service for execute logic
     * @return JsonResponse for response api
     */
    public function index(AssetService $service):JsonResponse
    {
        $data = $service->getAllData();

        return $this->responseWithResourceCollection(
            new AssetResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK
        );
    }

    public function show(AssetService $service, int $id):JsonResponse
    {
        $data = $service->getDataById($id);

        return $this->responseWithResource(
            new AssetResource($data),
            $this->responseName,
            $this->responseMessage['show'],
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
            'filename'=>$filename
        ) = $service->downloadById($id);

        return response()->download($path, $filename, $headers);
    }
}
