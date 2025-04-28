<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprUserHasRoleRepository
{

    public function createUserHasRoleRelationship($idUser, $idRole);

    public function findIdUserHasRoleRelationshipByRoleId($RoleId);
    
    // public function findIdUserHasRoleRelationShipByUserId($userId);

    // public function findRoleIdByUserHasRoleRelationShipId($userHasRoleRelationShipId);
}
