<?php

namespace App\Service;

use App\Models\SiprUser;
use App\Repository\Contracts\SiprUserRepository;
use App\Service\Contracts\SiprUserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SiprUserServiceImp implements SiprUserService
{
    public function getUserById($id)
    {   
        $user = SiprUser::query()
            ->select(["id", "username", "name", "password", "created_at", "updated_at"])
            ->where("id", "=", $id)
            ->first();

        Log::debug($user, ["SiprUserRepository.findUserById"]);
        return $user;
    }

    public function createUser($username, $name, $password)
    {
        SiprUser::create([
            "username" => $username,
            "name" => $name,
            "password" => Hash::make($password),
        ]);

        $idUser = $this->findIdUserByUsername($username);

        Log::debug(json_encode(["userId" => $idUser]), ["SiprUserRepositoryImp.createUser"]);
        return $idUser;
    }

    public function findIdUserByUsername($username): int
    {
        $idUser = SiprUser::query()
            ->select(["id"])
            ->where('username', "=", $username)
            ->first()
            ->id;

        Log::debug(json_encode(["userId" => $idUser]), ["SiprUserRepositoryImp.findIdUserByUsername"]);
        return $idUser;
    }
}
