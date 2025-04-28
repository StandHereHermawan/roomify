<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprUserHasPhoneNumberRepository;
use App\Domains\User\Service\Contracts\SiprUserHasPhoneNumberService;

class SiprUserHasPhoneNumberServiceImp implements SiprUserHasPhoneNumberService
{

    private SiprUserHasPhoneNumberRepository $repository;

    public function __construct(SiprUserHasPhoneNumberRepository $userHasEmailRepository)
    {
        $this->repository = $userHasEmailRepository;
    }

    public function createUserHasPhoneNumberRelationship($idUser, $idPhoneNumber)
    {
        $repository = $this->repository;
        return $repository->createUserHasPhoneNumberContactRelationship($idUser, $idPhoneNumber);
    }

    public function findPhoneNumberIdByUserHasPhoneNumberContactRelationShipId($userHasEmailRelationShipId) 
    {
        $repository = $this->repository;
        return $repository->findPhoneNumberIdByUserHasPhoneNumberContactRelationShipId($userHasEmailRelationShipId);
    }
}
