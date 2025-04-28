<?php

namespace App\Domains\User\Service\Contracts;

interface SiprEmailService {

    public function createEmail($email);
    
    public function findIdEmailByEmail($email);

    public function findModelEmailByEmail($email);
}