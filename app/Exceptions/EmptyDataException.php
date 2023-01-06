<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmptyDataException extends Exception
{
    public  $message;
    public function __construct(string $message = "The data you requested not found")
    {
        $this->message = $message;
    }
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success'   => false,
            'name' => 'Empty Data Exception',
            'message' => $this->message,
            'error_code' => 404,
            'error' => true,
        ])->setStatusCode(404);
    }
}
