<?php

namespace App\Http\Controllers\API;

use App\Exceptions\InvalidRegistrationCredential;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function mydata()
    {
        return response()->json(auth()->user());
    }

    // /**
    //  * Refresh a token.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function refresh()
    // {
    //     return response()->json([
    //         'access_token' => auth()->refresh(),
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
