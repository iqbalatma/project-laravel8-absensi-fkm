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
            'success'   => false,
            'name' => 'Empty Data Exception',
            'message'=> 'The data you requested not found',
            'error_code' => 404,
            'error' => true,
        ])->setStatusCode(404);
    }
}
