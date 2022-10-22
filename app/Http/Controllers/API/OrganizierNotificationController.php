<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\OrganizierNotificationStoreRequest;
use App\Http\Resources\OrganizierNotificationResource;
use App\Http\Resources\OrganizierNotificationResourceCollection;
use App\Services\OrganizierNotificationService;
use Illuminate\Http\JsonResponse;

class OrganizierNotificationController extends ApiController
{
    private string $responseName = 'Organizier Notifications';
    private array $responseMessage = [
        'index' => 'Get all organizier notifications successfully',
        'latest' => 'Get latest organizier notification successfully',
        'store' => 'Add new organizier notification successfully',
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
            $this->responseMessage['latest'],
            JsonResponse::HTTP_OK);
    }

    public function store(OrganizierNotificationService $service, OrganizierNotificationStoreRequest $request):JsonResponse
    {
        $data = $service->store($request->validated());

        return $this->responseWithResource(
            new OrganizierNotificationResource($data),
            $this->responseName,
            $this->responseMessage['store'],
            JsonResponse::HTTP_OK);
    }
}
