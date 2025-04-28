<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprUserHasEmail;
use App\Domains\User\Repository\Contracts\SiprUserHasEmailRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SiprUserHasEmailRepositoryImp implements SiprUserHasEmailRepository
{

    public function createUserHasEmailRelationship($userId, $emailId)
    {
        Log::debug(json_encode(["idUser" => $userId, "idEmail" => $emailId,]), ["SiprUserHasEmailRepositoryImp.createUserHasEmailRelation"]);

        $id = SiprUserHasEmail::create([
            "user_id" => $userId,
            "email_id" => $emailId,
            "created_at" => Carbon::now(),
            "updated_at" => null,
        ])->id;

        return $id;
    }

    public function findModelUserHasEmailRelationshipByEmailId($emailId) 
    {
        return SiprUserHasEmail::query()
        ->select()
        ->where('email_id', "=", $emailId)
        ->first();
    }

    public function findIdUserHasEmailRelationShipByUserId($idUser): int
    {
        $idUserHasEmail = SiprUserHasEmail::query()
            ->select(["id"])
            ->where('user_id', "=", $idUser)
            ->firstOrFail()
            ->id;

        Log::debug(json_encode(["idUserHasEmail" => $idUserHasEmail]), ["SiprUserHasEmailRepositoryImp.findIdUserHasEmailRelationShipByUserId"]);
        return $idUserHasEmail;
    }

    public function findIdUserHasEmailRelationshipByEmailId($idUser): int
    {
        $idUserHasEmail = SiprUserHasEmail::query()
            ->select(["id"])
            ->where('email_id', "=", $idUser)
            ->firstOrFail()
            ->id;

        Log::debug(json_encode(["idUserHasEmail" => $idUserHasEmail]), ["SiprUserHasEmailRepositoryImp.findIdUserHasEmailRelationshipByEmailId"]);
        return $idUserHasEmail;
    }

    public function findUserIdByUserHasEmailRelationShipId($userHasEmailRelationShipId): int
    {
        $idUserHasEmail = SiprUserHasEmail::query()
            ->select(["user_id"])
            ->where('id', "=", $userHasEmailRelationShipId)
            ->firstOrFail()
            ->id;

        Log::debug(json_encode(["userId" => $idUserHasEmail]), ["SiprUserHasEmailRepositoryImp.findUserIdByUserHasEmailRelationShipId"]);
        return $idUserHasEmail;
    }

    public function findEmailIdByUserHasEmailRelationShipId($userHasEmailRelationShipId): int
    {
        $emailId = SiprUserHasEmail::query()
            ->select(["email_id"])
            ->where('id', "=", $userHasEmailRelationShipId)
            ->firstOrFail()
            ->id;

        Log::debug(json_encode(["emailId" => $emailId]), ["SiprUserHasEmailRepositoryImp.findEmailIdByUserHasEmailRelationShipId"]);
        return $emailId;
    }
}
