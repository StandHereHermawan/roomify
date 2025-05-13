<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprUserRepository;
use App\Domains\User\Service\Contracts\SiprUserService;
use Illuminate\Support\Facades\Log;

class SiprUserServiceImp implements SiprUserService
{
    private SiprUserRepository $repository;


    public function __construct(
        SiprUserRepository $userRepo,
    ) {
        $this->repository = $userRepo;
    }

    public function createUser($username, $name, $password): int
    {
        $repository = $this->repository;
        $idUser = $repository->createUser($username, $name, $password);
        return $idUser;
    }

    public function findUserModelById($id){
        $repository = $this->repository;
        return $repository->findUserModelById($id);
    }
}
