<?php

namespace App\Service\Contracts;

interface SiprUserService
{

    public function getUserById($id);

    public function createUser($username, $name, $password);

    public function findIdUserByUsername($username);
}
