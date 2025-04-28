<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprRoleRepository;
use App\Domains\User\Service\Contracts\SiprRoleService;

class SiprRoleServiceImp implements SiprRoleService
{

    private SiprRoleRepository $repository;

    public function __construct(SiprRoleRepository $variable)
    {
        $this->repository = $variable;
    }

    public function createRole($role): int
    {
        $repo = $this->repository;
        $idPhoneNumber = $repo->createRole($role);
        return $idPhoneNumber;
    }
}
