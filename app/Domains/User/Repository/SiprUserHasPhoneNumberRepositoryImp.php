<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprUserHasPhoneNumber;
use App\Domains\User\Repository\Contracts\SiprUserHasPhoneNumberRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SiprUserHasPhoneNumberRepositoryImp implements SiprUserHasPhoneNumberRepository
{

    public function createUserHasPhoneNumberContactRelationship($userId, $phoneNumberContactId)
    {
        Log::debug(json_encode(["idUser" => $userId, "idPhoneNumber" => $phoneNumberContactId,]), ["SiprUserHasPhoneNumberContactRepositoryImp.createUserHasPhoneNumberContactRelationship"]);

        $id = SiprUserHasPhoneNumber::create([
            "user_id" => $userId,
            "phone_number_id" => $phoneNumberContactId,
            "created_at" => Carbon::now(),
            "updated_at" => null,
        ])->id;

        return $id;
    }

    public function findIdUserHasPhoneNumberContactRelationShipByUserId($idUser): int
    {
        $idUserHasEmail = SiprUserHasPhoneNumber::query()
            ->select(["id"])
            ->where('user_id', "=", $idUser)
            ->firstOrFail()
            ->id;

        Log::debug(json_encode(["idUserHasEmail" => $idUserHasEmail]), ["SiprUserHasPhoneNumberContactRepositoryImp.findIdUserHasEmailRelationShipByUserId"]);
        return $idUserHasEmail;
    }

    public function findIdUserHasPhoneNumberContactRelationshipByPhoneNumberId($phoneNumberId): int
    {
        $idUserHasEmail = SiprUserHasPhoneNumber::query()
            ->select(["id"])
            ->where('phone_number_id', "=", $phoneNumberId)
            ->firstOrFail()
            ->id;

        Log::debug(json_encode(["idUserHasEmail" => $idUserHasEmail]), ["SiprUserHasPhoneNumberContactRepositoryImp.findIdUserHasEmailRelationshipByEmailId"]);
        return $idUserHasEmail;
    }

    public function findUserIdByUserHasPhoneNumberContactRelationShipId($userHasPhoneNumberRelationShipId): int
    {
        $idUserHasEmail = SiprUserHasPhoneNumber::query()
            ->select(["user_id"])
            ->where('id', "=", $userHasPhoneNumberRelationShipId)
            ->firstOrFail()
            ->user_id;

        Log::debug(json_encode(["userId" => $idUserHasEmail]), ["SiprUserHasPhoneNumberContactRepositoryImp.findUserIdByUserHasEmailRelationShipId"]);
        return $idUserHasEmail;
    }

    public function findPhoneNumberIdByUserHasPhoneNumberContactRelationShipId($userHasEmailRelationShipId): int
    {
        $phoneNumberId = SiprUserHasPhoneNumber::query()
            ->select(["phone_number_id"])
            ->where('id', "=", $userHasEmailRelationShipId)
            ->firstOrFail()->phone_number_id;

        Log::debug(json_encode(["phoneNumberId" => $phoneNumberId]), ["SiprUserHasPhoneNumberContactRepositoryImp.findPhoneNumberIdByUserHasPhoneNumberContactRelationShipId"]);
        return $phoneNumberId;
    }
}
