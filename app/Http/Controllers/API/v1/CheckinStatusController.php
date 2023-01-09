<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\CheckinStatuses\CheckinStatusResourceCollection;
use App\Services\CheckinStatusService;
use Illuminate\Http\JsonResponse;

class CheckinStatusController extends ApiController
{
    private string $responseName = 'Checkin Statuses';
    private array $responseMessage = [
        'index' => 'Get list checkin status successfully',
    ];
    public function index(CheckinStatusService $service): JsonResponse
    {
        // ["columns" => $column] = request()->query()["search"];
        // return response()->json(["data" => $column]);
        $data = $service->getAllDataPaginated();
        return $this->responseWithResourceCollection(
            new CheckinStatusResourceCollection($data),
            $this->responseName,
            $this->responseMessage["index"]
        );
    }
}
