<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidRegistrationCredential extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => 1,
            'message'=> 'The credential you requested is invalid',
            'status'=> 404,
        ])->setStatusCode(404);
    }
}
