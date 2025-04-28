<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprPhoneNumberRepository
{

    public function createPhoneNumber($phoneNumber);

    public function findIdPhoneNumberByPhoneNumber($phoneNumber);
}
