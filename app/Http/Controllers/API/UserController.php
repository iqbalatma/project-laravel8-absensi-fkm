<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    private string $responseName = 'User';
    private array $responseMessage = [
        'index' => 'Get list users successfully',
        'show'  => 'Get single user successfully',
    ];

    /**
     * Description : use to get list user
     * 
     * @param UserService $service for execute logic
     * @param Request $request for get request data
     * @return JsonResponse for api response
     */
    public function index(UserService $service, Request $request):JsonResponse
    {
        $data = $service->getAll($request->only('role_id','generation'));
        return $this->responseWithResource(
            new UserResourceCollection($data),
            $this->responseName,
            $this->responseMessage['index'],
            200);
    }


    /**
     * Description : use to get detail data user by id
     * 
     * @param UserService $service for execute logic
     * @param int $id of user
     * @return JsonResponse for api response
     */
    public function show(UserService $service, int $id):JsonResponse
    {
        $data = $service->show($id);
        return $this->responseWithResource(
            new UserResource($data),
            $this->responseName,
            $this->responseMessage['show'],
            200);
    }
}
