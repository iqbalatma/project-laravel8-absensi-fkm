<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationCredentialStoreRequest;
use Illuminate\Http\Request;

class RegistrationCredentialController extends Controller
{
    public function store(RegistrationCredentialStoreRequest $request)
    {
        $validated = $request->validated();

        return response()->json($validated);
    }
}
