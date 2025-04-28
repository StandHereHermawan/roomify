<?php

namespace App\Domains\User\Service\Contracts;

interface SiprUserHasPhoneNumberService {
    
    public function createUserHasPhoneNumberRelationship($idUser, $idPhoneNumber);

    public function findPhoneNumberIdByUserHasPhoneNumberContactRelationShipId($userHasEmailRelationShipId);
}