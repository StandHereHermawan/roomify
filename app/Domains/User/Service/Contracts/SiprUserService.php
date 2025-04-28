<?php

namespace App\Domains\User\Service\Contracts;

interface SiprUserService
{

    public function createUser($username, $name, $password);

    public function findUserById($id);
    
}
