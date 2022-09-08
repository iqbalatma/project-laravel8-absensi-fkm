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
            'message'=> 'The credential you requested is invalid',
            'status'=> 404,
            'error' => 1,
        ])->setStatusCode(404);
    }
}
