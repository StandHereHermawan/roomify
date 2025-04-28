<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprUserHasEmailRepository
{

    public function createUserHasEmailRelationship($idUser, $idEmail);

    public function findModelUserHasEmailRelationshipByEmailId($emailId);

    public function findIdUserHasEmailRelationShipByUserId($userId);

    public function findIdUserHasEmailRelationshipByEmailId($emailId);

    public function findEmailIdByUserHasEmailRelationShipId($userHasEmailRelationShipId);
}
