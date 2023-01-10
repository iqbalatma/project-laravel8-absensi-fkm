<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\CheckinStatus\CheckinStatusResource;
use App\Http\Resources\CheckinStatuses\CheckinStatusResourceCollection;
use App\Services\CheckinStatusService;
use Illuminate\Http\JsonResponse;

class CheckinStatusController extends ApiController
{
    private string $responseName = 'Checkin Statuses';
    private array $responseMessage = [
        'index' => 'Get list checkin status successfully',
        "latest" => "Get latest checkin user successfully"
    ];
    public function index(CheckinStatusService $service): JsonResponse
    {
        $data = $service->getAllDataPaginated();
        return $this->responseWithResourceCollection(
            new CheckinStatusResourceCollection($data),
            $this->responseName,
            $this->responseMessage["index"]
        );
    }

    public function latest(CheckinStatusService $service): JsonResponse
    {
        $data = $service->getLatestCheckinUser();
        return $this->responseWithResource(
            new CheckinStatusResource($data),
            $this->responseName,
            $this->responseMessage["latest"],
            JsonResponse::HTTP_OK
        );
    }
}
