<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\UserManagement\StoreUserRequest;
use App\Http\Requests\UserManagement\UpdateUserRequest;
use App\Http\Resources\UserManagement\UserManagementResource;
use App\Http\Resources\UserManagement\UserManagementResourceCollection;
use App\Services\UserManagementService;
use Illuminate\Http\JsonResponse;

class UserManagementController extends ApiController
{

    private string $responseName = 'User Management';
    private array $responseMessage = [
        'index' => 'Get list users successfully',
        'show' => 'Get user by id successfully',
        'store' => 'Add new user successfully',
        'update' => 'Update user successfully',
        'changeStatusActiveSuccess' => 'Change status active user successfully',
        'changeStatusActiveFailed' => 'Change status active user failed',
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

    /**
     * Update data user by id
     *
     * @param UserManagementService $service
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UserManagementService $service, UpdateUserRequest $request, int $id): JsonResponse
    {
        return $this->responseWithResource(
            new UserManagementResource($service->updateDataById($id, $request->validated())),
            $this->responseName,
            $this->responseMessage["update"],
            JsonResponse::HTTP_OK
        );
    }

    public function changeActiveStatus(UserManagementService $service, int $id): JsonResponse
    {
        $deactivated = $service->changeActiveStatus($id);
        if ($deactivated) {
            $response = [
                "success" => true,
                "name" => $this->responseName,
                "message" => $this->responseMessage["changeStatusActiveSuccess"]
            ];
        } else {
            $response = [
                "success" => true,
                "name" => $this->responseName,
                "message" => $this->responseMessage["changeStatusActiveFailed"]
            ];
        }
        return $this->apiResponse($response, JsonResponse::HTTP_OK);
    }
}
