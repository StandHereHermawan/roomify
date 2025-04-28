<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprRole;
use App\Domains\User\Repository\Contracts\SiprRoleRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SiprRoleRepositoryImp implements SiprRoleRepository {

    public function createRole($role): int
    {
        Log::debug(json_encode(["newRegisteredRole" => $role]), ["SiprRoleRepositoryImp.createRole"]);

        SiprRole::create([
            "role" => $role,
            "created_at" => Carbon::now()
        ]);

        $idEmail = $this->findIdRoleByRole($role);

        return $idEmail;
    }

    public function findIdRoleByRole($role): int
    {
        Log::debug(json_encode(["roleToBeFind" => $role]), ["SiprRoleRepositoryImp.findIdRoleByRole"]);

        $phoneNumberId = SiprRole::query()
            ->select(["id"])
            ->where('role', '=', $role)
            ->firstOrFail()
            ->id;

        return $phoneNumberId;
    }
}