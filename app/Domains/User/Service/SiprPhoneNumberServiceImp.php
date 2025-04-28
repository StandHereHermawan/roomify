<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprPhoneNumberRepository;
use App\Domains\User\Service\Contracts\SiprPhoneNumberService;

class SiprPhoneNumberServiceImp implements SiprPhoneNumberService
{

    private SiprPhoneNumberRepository $repository;

    public function __construct(SiprPhoneNumberRepository $variable)
    {
        $this->repository = $variable;
    }

    public function createPhoneNumber($phoneNumber)
    {
        $repo = $this->repository;
        $idPhoneNumber = $repo->createPhoneNumber($phoneNumber);
        return $idPhoneNumber;
    }
}
