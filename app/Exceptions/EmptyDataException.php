<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmptyDataException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'status'=> 404,
            'message'=> 'The data you requested not found',
            'error' => 1,
        ])->setStatusCode(404);
    }
}
