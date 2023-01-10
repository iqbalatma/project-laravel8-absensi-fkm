<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\Monitoring\MonitoringResource;
use App\Services\MonitoringService;
use Illuminate\Http\JsonResponse;

class MonitoringController extends ApiController
{
    private string $responseName = "Monitoring";
    private array $responseMessage = [
        "index" => "Get all data monitoring successfully",
    ];
    public function index(MonitoringService $service): JsonResponse
    {
        $data = $service->getAllData();
        return $this->responseWithResource(
            new MonitoringResource($data),
            $this->responseName,
            $this->responseMessage["index"],
            JsonResponse::HTTP_OK
        );
    }
}
