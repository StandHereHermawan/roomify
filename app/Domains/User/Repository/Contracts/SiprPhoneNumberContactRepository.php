<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprPhoneNumberContactRepository
{

    public function createPhoneNumber($phoneNumber);

    public function findIdPhoneNumberByPhoneNumber($phoneNumber);
}
