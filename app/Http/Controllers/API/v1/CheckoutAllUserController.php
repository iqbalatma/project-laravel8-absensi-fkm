<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\CheckoutAllUsers\CheckoutAllUserRequest;
use App\Services\CheckoutAllUserService;
use Illuminate\Http\JsonResponse;

class CheckoutAllUserController extends ApiController
{
    private string $responseName = "Checkout All Users";
    private array  $responseMessage = [
        "checkoutSuccess" =>    "Checkout all users successfully",
        "checkoutFaield" =>    "Checkout all users failed",
    ];

    public function __invoke(CheckoutAllUserService $service, CheckoutAllUserRequest $request): JsonResponse
    {
        $data = $service->checkoutAllUserByDate($request->validated());

        if ($data) {
            return $this->apiResponse([
                "success" => true,
                "name" => $this->responseName,
                "message" => $this->responseMessage["checkoutSuccess"]
            ]);
        } else {
            return $this->apiResponse([
                "success" => false,
                "name" => $this->responseName,
                "message" => $this->responseMessage["checkoutFaield"]
            ]);
        }
    }
}
