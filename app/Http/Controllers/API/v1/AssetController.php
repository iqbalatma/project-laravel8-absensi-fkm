<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssetController extends ApiController
{
    private string $responseName = 'Assets';
    private array $responseMessage = [
        'index' => 'Get list assets successfully',
        'show' => 'Get singe asset successfully',
    ];
}
