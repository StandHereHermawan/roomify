<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprPhoneNumberContactRepository;
use App\Domains\User\Service\Contracts\SiprPhoneNumberContactService;

class SiprPhoneNumberContactServiceImp implements SiprPhoneNumberContactService
{

    private SiprPhoneNumberContactRepository $repository;

    public function __construct(SiprPhoneNumberContactRepository $variable)
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
