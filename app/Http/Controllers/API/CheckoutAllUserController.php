<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutAllUserRequest;
use App\Services\CheckoutAllUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutAllUserController extends ApiController
{
    private string $responseName = "Checkout all user";
    public function checkoutAllUsers(CheckoutAllUserService $service, CheckoutAllUserRequest $request)
    {
        $data = $service->checkoutAllUserByDate($request->validated());
        if($data){
            return $this->apiResponse([
                "success"=> true,
                "name"=> $this->responseName,
                "message"=> "Checkout all user successfully",
            ],JsonResponse::HTTP_OK);
        }else{
            return $this->apiResponse([
                "success"=> false,
                "name"=> $this->responseName,
                "message"=> "Checkout all user failed",
            ],JsonResponse::HTTP_OK);
        }
    }
}
