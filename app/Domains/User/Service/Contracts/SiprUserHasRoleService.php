<?php

namespace App\Domains\User\Service\Contracts;

interface SiprUserHasRoleService {
    
    public function createUserHasRoleRelationship($idUser, $idRole);

    public function findIdUserHasRoleRelationshipByRoleId($RoleId);
}