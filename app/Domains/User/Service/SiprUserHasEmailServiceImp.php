<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprUserHasEmailRepository;
use App\Domains\User\Service\Contracts\SiprUserHasEmailService;

class SiprUserHasEmailServiceImp implements SiprUserHasEmailService
{

    private SiprUserHasEmailRepository $repository;

    public function __construct(SiprUserHasEmailRepository $userHasEmailRepository)
    {
        $this->repository = $userHasEmailRepository;
    }

    public function createUserHasEmailRelationship($idUser, $idEmail)
    {
        $repository = $this->repository;
        return $repository->createUserHasEmailRelationship($idUser, $idEmail);
    }

    public function findIdUserHasEmailRelationshipByEmailId($emailId) 
    {
        $repository = $this->repository;
        return $repository->findIdUserHasEmailRelationshipByEmailId( $emailId);
    }

    public function findModelUserHasEmailRelationshipByEmailId($emailId) 
    {
        $repository = $this->repository;
        return $repository->findModelUserHasEmailRelationshipByEmailId( $emailId);
    }
}
