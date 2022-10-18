<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnauthorizedException extends Exception
{
    protected $message;
    
    public function __construct($message ='You are unauthorized to do this request', $code = 403) {
        $this->message = $message;
        $this->code = $code;
    }
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success'   => false,
            'name'      => 'Unauthorized',
            'message'   => $this->message,
            'error_code'=> $this->code,
            'error' => true,
        ])->setStatusCode($this->code);
    }
}
