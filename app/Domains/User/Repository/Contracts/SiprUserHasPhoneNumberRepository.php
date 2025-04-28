<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprUserHasPhoneNumberRepository
{

    public function createUserHasPhoneNumberContactRelationship($idUser, $idEmail);

    public function findIdUserHasPhoneNumberContactRelationShipByUserId($userId);

    public function findIdUserHasPhoneNumberContactRelationshipByPhoneNumberId($phoneNumberId);

    public function findPhoneNumberIdByUserHasPhoneNumberContactRelationShipId($userHasPhoneNumberRelationShipId);

    public function findUserIdByUserHasPhoneNumberContactRelationShipId($userHasPhoneNumberRelationShipId);
}
