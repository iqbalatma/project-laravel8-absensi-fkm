<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\OrganizerNotifications\StoreOrganizerNotificationRequest;
use App\Http\Resources\OrganizerNotification\OrganizerNotificationResource;
use App\Http\Resources\OrganizerNotification\OrganizerNotificationResourceCollection;
use App\Services\OrganizerNotificationService;
use Illuminate\Http\JsonResponse;

class OrganizerNotificationController extends ApiController
{
    private string $responseName = 'Organizer Notifications';
    private array $responseMessage = [
        'index' => 'Get list organizer notifications successfully',
        'latest' => 'Get latest organizer notification successfully',
        'store' => 'Add new organizer notification successfully',
    ];

    public function index(OrganizerNotificationService $service): JsonResponse
    {
        $data = $service->getAllDataPaginated();
        return $this->responseWithResourceCollection(
            new OrganizerNotificationResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK
        );
    }

    public function store(OrganizerNotificationService $service, StoreOrganizerNotificationRequest $request): JsonResponse
    {
        return $this->responseWithResource(
            new OrganizerNotificationResource($service->addNewData($request->validated())),
            $this->responseName,
            $this->responseMessage["store"],
            JsonResponse::HTTP_CREATED
        );
    }

    public function latest(OrganizerNotificationService $service): JsonResponse
    {
        return $this->responseWithResource(
            new OrganizerNotificationResource($service->getLatestData()),
            $this->responseName,
            $this->responseMessage["latest"],
            JsonResponse::HTTP_OK
        );
    }
}
