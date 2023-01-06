<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmptyDataException extends Exception
{
    public $data;
    public function __construct($param)
    {
        $this->data = $param;
    }
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success'   => false,
            'name' => 'Empty Data Exception',
            'message' => 'The data you requested not found',
            'error_code' => 404,
            'error' => true,
            'tes' => $this->data
        ])->setStatusCode(404);
    }
}
