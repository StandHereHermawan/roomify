<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprUserRepository;
use App\Domains\User\Service\Contracts\SiprUserService;
use Illuminate\Support\Facades\Log;

class SiprUserServiceImp implements SiprUserService
{
    private SiprUserRepository $repository;

    public function __construct(SiprUserRepository $variable) 
    {
        $this->repository = $variable;
    }

    public function createUser($username, $name, $password): int
    {
        $service = $this->repository;

        Log::debug(json_encode(["username" => $username, "name" => $name]), ["SiprUserServiceImp.createUser"]);

        $idUser = $service->createUser($username, $name, $password);

        Log::debug(json_encode(["userId" => $idUser]), ["SiprUserServiceImp.createUser"]);

        return $idUser;
    }
}
