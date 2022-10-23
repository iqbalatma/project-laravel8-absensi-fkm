<?php

namespace App\Http\Controllers\API\Auth;

use App\Exceptions\InvalidRegistrationCredential;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterManualRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\RegistrationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController
{
    private RegistrationService $registrationService;
    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
        $this->middleware('auth:api', ['except' => ['login','register','refresh']]);
    }


    /**
     * Description : Used for user login and return token
     * 
     * @param LoginRequest $request for validate email and password
     */
    public function login(LoginRequest $request):JsonResponse
    {
        $token = JWTAuth::attempt($request->validated());
        if (!$token) {
            throw new UnauthorizedException('Invalid username or password');
        }
        $user = Auth::user();
        return $this->apiResponse([
            'success' => true,
            'name' => "Login",
            'message' => "Login user successfully",
            'result'=>[
                'user'=>$user,
                'authorization'=>[
                    'token' => $token,
                    'type'  => 'bearer'
                ]
            ]
        ],JsonResponse::HTTP_OK);
    }


    /**
     * Description : use for register new user with registraition credential
     * 
     * @param RegisterRequest $request for validation rule
     * @param string $registrationCredential for validate is register is allowed
     * @return JsonResponse for response api
     */
    public function register(RegisterRequest $request, string $registrationCredential):JsonResponse
    {
        $registeredUser = $this->registrationService->register($registrationCredential,$request->validated());

        if($registeredUser===404){
            throw new InvalidRegistrationCredential();
        }

        return $this->apiResponse([
            'success' => true,
            'name' => "Registration",
            'message' => "Registration user successfully",
            'result' => $registeredUser
        ],JsonResponse::HTTP_OK);
    }


    /**
     * Description : use for register new user with registraition credential
     * 
     * @param RegisterManualRequest $request for validation rule
     * @param string $registrationCredential for validate is register is allowed
     * @return JsonResponse for response api
     */
    public function registerManual(RegisterManualRequest $request):JsonResponse
    {
        $registeredUser = $this->registrationService->registerManual($request->validated());


        return $this->apiResponse([
            'success' => true,
            'name' => "Registration",
            'message' => "Registration user successfully",
            'result' => $registeredUser
        ],JsonResponse::HTTP_OK);
    }

    /**
     * Description : use for logout current user by token
     * 
     * @return JsonResponse for api response
     */
    public function logout():JsonResponse
    {
        Auth::logout();
        return $this->apiResponse([
            'success' => true,
            'name' => "Logout",
            'message' => "Logout user successfully",
        ],JsonResponse::HTTP_OK);
    }


    /**
     * Description : use for refresh token
     * 
     * @return JsonResponse for api respones
     */
    public function refresh():JsonResponse
    {
        return $this->apiResponse([
            'success' => true,
            'name' => "Refresh token",
            'message' => "Refresh token user successfully",
            'result'=>[
                'user'=>Auth::user(),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ]
        ],JsonResponse::HTTP_OK);
    }

    public function me()
    {
        return $this->apiResponse([
            'success' => true,
            'name' => "Logged in user information",
            'message' => "Get logged in user information successfully",
            'result'=>[
                'data'=> auth()->user()
            ]
        ],JsonResponse::HTTP_OK);
    }
}
