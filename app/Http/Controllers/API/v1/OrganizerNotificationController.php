<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizerNotification\OrganizerNotificationResourceCollection;
use App\Services\OrganizierNotificationService;
use Illuminate\Http\JsonResponse;

class OrganizerNotificationController extends Controller
{
    private string $responseName = 'Organizier Notifications';
    private array $responseMessage = [
        'index' => 'Get all organizier notifications successfully',
        'latest' => 'Get latest organizier notification successfully',
        'store' => 'Add new organizier notification successfully',
    ];

    public function index(OrganizierNotificationService $service): JsonResponse
    {
        $data = $service->getAllData();
        return $this->responseWithResourceCollection(
            new OrganizerNotificationResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            JsonResponse::HTTP_OK
        );
    }
}
