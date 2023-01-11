<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Repositories\RegistrationCredentialRepository;
use App\Repositories\UserRepository;

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
        $this->regCredsRepo->decreaseLimitByToken($credential);
        return $this->repository->addNewData($requestedData);
    }
}
