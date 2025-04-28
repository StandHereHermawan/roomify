<?php

namespace App\Domains\User\Service\Contracts;

interface SiprUserHasEmailService
{

    public function createUserHasEmailRelationship($idUser, $idEmail);
    
    public function findModelUserHasEmailRelationshipByEmailId($emailId);
    
    public function findIdUserHasEmailRelationshipByEmailId($emailId);

}