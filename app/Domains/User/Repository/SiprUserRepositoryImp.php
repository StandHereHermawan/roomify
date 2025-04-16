<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprUser;

use App\Domains\User\Repository\Contracts\SiprUserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SiprUserRepositoryImp implements SiprUserRepository
{

    public function createUser($username, $name, $password): int
    {
        SiprUser::create([
            "username" => $username,
            "name" => $name,
            "password" => Hash::make($password),
            "created_at" => Carbon::now(),
            "updated_at" => null,
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
            ->firstOrFail()
            ->id;

        Log::debug(json_encode(["userId" => $idUser]), ["SiprUserRepositoryImp.findIdUserByUsername"]);
        return $idUser;
    }

    public function findUsernameByIdUser($id): string
    {
        $username = SiprUser::query()
            ->select(["username"])
            ->where('id', "=", $id)
            ->firstOrFail()
            ->username;

        Log::debug(json_encode(["username" => $username]), ["SiprUserRepositoryImp.findIdUserByUsername"]);
        return $username;
    }

    public function findUserById($id): SiprUser
    {
        $user = SiprUser::query()
            ->select(["id", "username", "name", "password", "created_at", "updated_at"])
            ->where("id", "=", $id)
            ->firstOrFail();

        Log::debug($user, ["SiprUserRepository.findUserById"]);
        return $user;
    }

    public function findUserByUsername($username): SiprUser
    {
        $user = SiprUser::query()
            ->select(["id", "username", "name", "password", "created_at", "updated_at"])
            ->where('username', "=", $username)
            ->firstOrFail();

        Log::debug($user, ["SiprUserRepository.findUserByUsername"]);
        return $user;
    }

    public function updateUserItsNameByUsername($username, $newName): void
    {
        $user = $this->findUserByUsername($username);

        Log::debug(json_encode(["user" => $user]), ["SiprUserRepositoryImp.updateUserItsNameByUsername"]);

        $user->update([
            "name" => $newName ?? $user->name,
            "updated_at" => Carbon::now(),
        ]);

        $user->save();
    }

    public function updateUserItsNameById($id, $newName): void
    {
        $user = $this->findUserById($id);

        Log::debug(json_encode(["user" => $user]), ["SiprUserRepositoryImp.updateUserItsNameById"]);

        $user->update([
            "name" => $newName ?? $user->name,
            "updated_at" => Carbon::now(),
        ]);

        $user->save();
    }

    public function updateUserItsUsernameById($id, $newUsername): void
    {
        $user = $this->findUserById($id);

        Log::debug(json_encode(["user" => $user, "newUsername" => $newUsername]), ["SiprUserRepositoryImp.updateUserItsUsernameById"]);

        $user->update([
            "username" => $newUsername,
            "updated_at" => Carbon::now(),
        ]);

        $user->save();
    }

    public function deleteUserByUsername($username): int
    {
        $user = $this->findUserByUsername($username);

        Log::debug(json_encode(["user" => $user]), ["SiprUserRepositoryImp.deleteUserByUsername"]);

        $deletedUserId = $user->id;
        $user->delete();

        return $deletedUserId;
    }

    public function deleteUserById($id): int
    {
        $user = $this->findUserById($id);

        Log::debug(json_encode(["user" => $user]), ["SiprUserRepositoryImp.deleteUserById"]);

        $deletedUserId = $user->id;
        $user->delete();

        return $deletedUserId;
    }
}
