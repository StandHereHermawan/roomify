<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprRoleRepository
{

    public function createRole($role);

    public function findIdRoleByRole($role);
}
