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
            'error' => 1,
            'message'=> 'The data you requested not found',
            'status'=> 404,
        ])->setStatusCode(404);
    }
}
