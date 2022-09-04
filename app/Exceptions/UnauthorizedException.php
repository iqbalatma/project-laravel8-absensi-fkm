<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnauthorizedException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        $status = 400;
        $error = "Something is wrong";
        $help = "Contact the sales team to verify";

        return response()->json([
            'error' => 1,
            'message'=> 'You are unauthorized to do this action',
            'status'=> 401
        ])->setStatusCode(401);
    }
}
