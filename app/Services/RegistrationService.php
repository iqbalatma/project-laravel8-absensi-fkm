<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Repositories\RegistrationCredentialRepository;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationService extends BaseService
{
    protected $repository;
    protected $regCredsRepo;

    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->regCredsRepo = new RegistrationCredentialRepository();
    }

    public function registrationWithCredential(string $credential, array $requestedData): object
    {
        $requestedData["password"] = Hash::make($requestedData["password"]);
        $requestedData["personal_token"] = Str::random(16);
        $this->regCredsRepo->decreaseLimitByToken($credential);
        $user = $this->repository->addNewData($requestedData);
        event(new Registered($user));
        return $user;
    }
}
