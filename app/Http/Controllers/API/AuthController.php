<?php

namespace App\Http\Controllers\API;

use App\Exceptions\InvalidRegistrationCredential;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\RegistrationCredential;
use App\Models\User;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class AuthController extends ApiController
{
    private RegistrationService $registrationService;
    public function __construct(RegistrationService $registrationService) {
        $this->registrationService = $registrationService; 
    }
    public function register(RegisterRequest $request, string $registrationCredential): JsonResponse
    {
        $registeredUser = $this->registrationService->register($registrationCredential,$request->validated());

        if($registeredUser===404){
            throw new InvalidRegistrationCredential();
        }

        return $this->apiResponse([
            'success' => true,
            'name' => "Registration",
            'message' => "Registration user successfully",
            'result' => [
                'user'=> $registeredUser[0],
                'acess_token'=> $registeredUser[1]
            ],
        ],200);
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
