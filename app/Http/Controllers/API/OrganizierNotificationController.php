<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OrganizierNotificationResource;
use App\Http\Resources\OrganizierNotificationResourceCollection;
use App\Services\OrganizierNotificationService;
use Illuminate\Http\JsonResponse;

class OrganizierNotificationController extends ApiController
{
    private string $responseName = 'Organizier Notifications';
    private array $responseMessage = [
        'index' => 'Get all organizier notifications successfully',
    ];

    public function index(OrganizierNotificationService $service):JsonResponse
    {
        $data = $service->getAllData();
        return $this->responseWithResourceCollection(
            new OrganizierNotificationResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK);
    }

    public function latest(OrganizierNotificationService $service):JsonResponse
    {
        $data = $service->getLatestData();
        return $this->responseWithResource(
            new OrganizierNotificationResource($data),
            $this->responseName,
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK);
    }
}
