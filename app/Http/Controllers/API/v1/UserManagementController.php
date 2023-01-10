<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\StoreUserRequest;
use App\Http\Resources\UserManagement\UserManagementResource;
use App\Http\Resources\UserManagement\UserManagementResourceCollection;
use App\Services\UserManagementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserManagementController extends ApiController
{

    private string $responseName = 'User Management';
    private array $responseMessage = [
        'index' => 'Get list users successfully',
        'show' => 'Get user by id successfully',
        'store' => 'Add new user successfully',
        'update' => 'Update user successfully',
        'destroy' => 'Delete user successfully',
    ];

    /**
     * Get list data users
     *
     * @param UserManagementService $service
     * @return JsonResponse
     */
    public function index(UserManagementService $service): JsonResponse
    {
        return $this->responseWithResourceCollection(
            new UserManagementResourceCollection($service->getAllDataPaginated()),
            $this->responseName,
            $this->responseMessage["index"],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Get data user by id
     *
     * @param UserManagementService $service
     * @param int $id
     * @return JsonResponse
     */
    public function show(UserManagementService $service, int $id): JsonResponse
    {
        return $this->responseWithResource(
            new UserManagementResource($service->getDataById($id)),
            $this->responseName,
            $this->responseMessage["show"],
            JsonResponse::HTTP_OK
        );
    }


    /**
     * Store new data user
     *
     * @param UserManagementService $service
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(UserManagementService $service, StoreUserRequest $request): JsonResponse
    {
        return $this->responseWithResource(
            new UserManagementResource($service->addNewData($request->validated())),
            $this->responseName,
            $this->responseMessage["store"],
            JsonResponse::HTTP_CREATED
        );
    }

    public function update()
    {
    }

    public function deactive()
    {
    }
}
