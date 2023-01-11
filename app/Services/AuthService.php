<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService
{
    protected  $repository;

    private array $responseAuthentication = [
        "success" => true,
        "name" => "Authentication",
        "message" => "Authentication successfully",
        "payload" => [
            "data" => [
                "type" => "bearer",
            ]
        ]
    ];

    public function authenticate(array $credential)
    {
        $token = $this->getAccessToken($credential);
        if (!$token) {
            throw new UnauthorizedException('Invalid username or password');
        }
        $refreshToken = $this->getRefreshToken();
        $user = $this->getDataUser();

        return array_merge_recursive($this->responseAuthentication, [
            "payload" => [
                "data" => [
                    "user" => $user,
                    "token" => $token,
                    "refresh" => $refreshToken
                ]
            ]
        ]);
    }

    public function logout(): array
    {
        if (Auth::user()) {
            Auth::logout(true);
            return [
                'success' => true,
                'name'    => "Logout",
                'message' => "Logout user successfully",
            ];
        };

        throw new UnauthorizedException("Your token is invalid, please login to get new token");
    }


    public function refresh()
    {
        if (!Auth::check()) {
            throw new UnauthorizedException('Invalid or expired token');
        }
        $this->invalidateToken();
        $refreshToken = $this->getRefreshToken();
        $token = $this->getAccessToken();
        $user = $this->getDataUser();

        $response = [
            "message" => "Refresh successfully",
            "payload" => [
                "data" => [
                    "user"    => $user,
                    "token"   => $token,
                    "refresh" => $refreshToken
                ]
            ]
        ];
        return array_merge_recursive_distinct($this->responseAuthentication, $response);
    }

    public function getDataUser()
    {
        $user = Auth::user();
        $user["organization_name"] = $user->organization->name ?? null;
        $user["role_name"] = $user->role->name ?? null;
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

        return $user;
    }
    private function getAccessToken(array $credential = null)
    {
        $ttl = config("jwt.ttl");
        if ($credential) {
            $token = Auth::setTTL($ttl)->attempt($credential);
        } else {
            $token = Auth::setTTL($ttl)->login(Auth::user());
        }

        return $token;
    }

    private function getRefreshToken()
    {
        return Auth::setTTL(config("jwt.refresh_ttl"))->login(Auth::user());
    }

    private function invalidateToken()
    {
        Auth::invalidate();
    }
}
