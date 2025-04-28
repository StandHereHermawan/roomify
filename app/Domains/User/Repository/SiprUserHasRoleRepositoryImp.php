<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprUserHasEmail;
use App\Domains\User\Model\SiprUserHasRole;
use App\Domains\User\Repository\Contracts\SiprUserHasRoleRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SiprUserHasRoleRepositoryImp implements SiprUserHasRoleRepository
{

    public function createUserHasRoleRelationship($idUser, $idRole)
    {
        $id = SiprUserHasRole::create([
            "user_id" => $idUser,
            "role_id" => $idRole,
            "created_at" => Carbon::now(),
            "updated_at" => null,
        ])->id;
        return $id;
    }

    public function findIdUserHasRoleRelationshipByRoleId($RoleId) 
    {
        $idUserHasRole = SiprUserHasRole::query()
            ->select(["id"])
            ->where('role_id', "=", $RoleId)
            ->firstOrFail()
            ->id;
        return $idUserHasRole;
    }
}
