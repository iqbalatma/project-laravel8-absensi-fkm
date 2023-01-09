<?php

namespace App\Http\Controllers\API\v1;

class CheckinStatusController extends ApiController
{
    private string $responseName = 'Checkin Statuses';
    private array $responseMessage = [
        'index' => 'Get list checkin status successfully',
        'checkin' => 'Checkin user successfully',
        'checkout' => 'Checkout user successfully',
    ];
    public function index()
    {
    }
}
