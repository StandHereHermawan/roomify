<?php

namespace App\Domains\User\Service\Contracts;

interface SiprPhoneNumberContactService {
    
    public function createPhoneNumber($phoneNumber);
}