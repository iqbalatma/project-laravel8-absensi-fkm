<?php

namespace App\Http\Controllers\API;

use App\Exceptions\InvalidRegistrationCredential;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\RegistrationCredential;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request, string $registrationCredential): JsonResponse
    {
        /**
         * ORGANIZATION ID problem
         */
        $dataRegistrationCredential = RegistrationCredential::where([
            'token' => $registrationCredential,
            'is_active' => 1
        ])
            ->where('limit', '>', 0)
            ->first();

        if(empty($dataRegistrationCredential)) throw new InvalidRegistrationCredential();

        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role_id'] = $dataRegistrationCredential->role_id;
        $validated['personal_token'] = Str::random(16);
        $validated['organization_id'] =  $dataRegistrationCredential->organization_id ?? $validated['organization_id'];
        $user = User::create($validated);
        $dataRegistrationCredential->decrement('limit');

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
    }

    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json([
                    'message' => 'Invalid email or password',
                    'status' => 401
                ])->setStatusCode(401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['status'=>200,'message' => 'Login successfully', 'data'=>['access_token' => $token, 'token_type' => 'Bearer'],])->setStatusCode(200);
    }
}
