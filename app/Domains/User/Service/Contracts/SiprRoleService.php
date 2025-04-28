<?php

namespace App\Domains\User\Service\Contracts;

interface SiprRoleService {
    
    public function createRole($phoneNumber);
}