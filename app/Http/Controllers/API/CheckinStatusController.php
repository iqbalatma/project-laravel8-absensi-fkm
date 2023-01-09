<?php

namespace App\Http\Controllers\API;

use App\Exceptions\RequestErrorException;
use App\Http\Requests\CheckinByCongressDateRequest;
use App\Http\Requests\CheckinStatusStoreRequest;
use App\Http\Resources\CheckinStatusResourceCollection;
use App\Http\Status;
use App\Models\CheckinStatus;
use App\Models\User;
use App\Repositories\CheckinRepository;
use App\Services\CheckinService;
use Illuminate\Http\JsonResponse;

class CheckinStatusController extends ApiController
{
    private string $responseName = 'Checkin Status';
    private array $responseMessage = [
        'index' => 'Get list checkin status successfully',
        'checkin' => 'Checkin user successfully',
        'checkout' => 'Checkout user successfully',
    ];


    /**
     * Description : use to get data checkin status
     *
     * @param CheckinStatusService $service for execute logic
     * @return JsonResponse for api response
     */
    public function index(CheckinService $service): JsonResponse
    {
        $totalPerpage = request()->get('total_per_page') ?? null;
        $data = $service->getAllData($totalPerpage, request()->only(
            'checkin_status',
            'congress_day_id',
            'congress_date',
            'role_id',
            'generation',
            'organization_id'
        ));

        return $this->responseWithResourceCollection(
            new CheckinStatusResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            200
        );
    }
}
