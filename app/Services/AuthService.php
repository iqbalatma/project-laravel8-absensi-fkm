<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Repositories\CongressDayRepository;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService
{
    protected  $repository;

    public function __construct()
    {
    }

    public function authenticate(array $credential)
    {
        $token = Auth::attempt($credential);
        if (!$token) {
            throw new UnauthorizedException('Invalid username or password');
        }
        $user = Auth::user();
        $user["organization_name"] = $user->organization->name;
        $user["role_name"] = $user->role->name;
        $user = $user->only([
            "id",
            "name",
            "email",
            "student_id",
            "generation",
            "phone_number",
            "organization_name",
            "role_name"
        ]);



        return [
            "success" => "true",
            "name" => "Authentication",
            "message" => "Authentication successfully",
            "payload" => [
                "data" => [
                    "user" => $user,
                    "type" => "bearer",
                    "token" => $token,
                ]
            ]
        ];
    }
}
