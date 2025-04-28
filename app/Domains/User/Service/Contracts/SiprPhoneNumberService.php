<?php

namespace App\Domains\User\Service\Contracts;

interface SiprPhoneNumberService {
    
    public function createPhoneNumber($phoneNumber);
}