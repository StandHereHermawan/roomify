<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprUserHasRoleRepository;
use App\Domains\User\Service\Contracts\SiprUserHasRoleService;

class SiprUserHasRoleServiceImp implements SiprUserHasRoleService
{
    private SiprUserHasRoleRepository $repository;

    public function __construct(SiprUserHasRoleRepository $repo)
    {
        $this->repository = $repo;
    }

    public function createUserHasRoleRelationship($idUser, $idRole)
    {
        $repository = $this->repository;
        return $repository->createUserHasRoleRelationship($idUser, $idRole);
    }

    public function findIdUserHasRoleRelationshipByRoleId($roleId)
    {
        $repository = $this->repository;
        return $repository->findIdUserHasRoleRelationshipByRoleId( $roleId);
    }
}
