<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnauthorizedException extends Exception
{
    protected $message;
    public function __construct($message ='You are unauthorized to do this request') {
        $this->message = $message;
    }
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message'=> $this->message,
            'status'=> 401,
            'error' => true,
        ])->setStatusCode(401);
    }
}
