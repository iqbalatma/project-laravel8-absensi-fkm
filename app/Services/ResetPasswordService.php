<?php

namespace App\Services;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordService extends BaseService
{
    public function requestResetLink(array $requestedData): array
    {
        $status = Password::sendResetLink($requestedData);
        $response = ["name" => "Forgot Password"];
        if ($status === Password::RESET_LINK_SENT) {
            $response = array_merge($response, [
                "success" => true,
                "message" => "Reset password requested",
            ]);
        }
        $response = array_merge($response, [
            "success" => false,
            "message" => "Something went wrong",
        ]);

        return $response;
    }

    public function resetPassword(array $requestedData)
    {
        $status = Password::reset(
            $requestedData,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        $response = ["name" => "Forgot Password"];


        if ($status === Password::PASSWORD_RESET) {
            $response = array_merge($response, [
                "success" => true,
                "message" => "Reset password successfully",
            ]);
        }
        $response = array_merge($response, [
            "success" => false,
            "message" => "Something went wrong",
        ]);

        return $response;
    }
}
