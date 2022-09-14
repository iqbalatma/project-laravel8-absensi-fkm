<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidRegistrationCredential extends Exception
{
    protected $message;
    public function __construct($message ='The credential registration token you used is invalid', $status= 400) {
        $this->message = $message;
        $this->status = $status;
    }
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success'   => false,
            'name' => 'Invalid RegistrationCredential',
            'message'   => $this->message,
            'error_code' => $this->status,
            'error' => true,
        ])->setStatusCode($this->status);
    }
}
