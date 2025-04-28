<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprUser;

use App\Domains\User\Repository\Contracts\SiprUserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SiprUserRepositoryImp implements SiprUserRepository
{

    public function createUser($username, $name, $password): ?int
    {
        Log::debug(json_encode("SiprUserRepositoryImp@createUser called"), ["user" => ["username" => $username, "name" => $name, "password" => $password]]);
        $idUser = SiprUser::create([
            "username" => $username,
            "name" => $name,
            // "password" => Hash::make($password),
            "password" => password_hash($password, PASSWORD_BCRYPT, [["rounds" => Env::get("BCRYPT_ROUNDS", 5)]]), //
            "created_at" => Carbon::now(),
            "updated_at" => null,
        ])->id;
        Log::debug(json_encode("SiprUserRepositoryImp@createUser return"), ["user" => ["id" => $idUser]]);
        
        return $idUser;
    }

    public function findIdUserByUsername($username): int
    {
        Log::debug(json_encode("SiprUserRepositoryImp@findIdUserByUsername called"), ["username" => $username]);
        $idUser = SiprUser::query()
            ->select(["id"])
            ->where('username', "=", $username)
            ->firstOrFail()
            ->id;
        Log::debug(json_encode("SiprUserRepositoryImp@createUser return"), ["user" => ["id" => $idUser]]);
        return $idUser;
    }

    public function findUsernameByIdUser($id): string
    {
        Log::debug(json_encode("SiprUserRepositoryImp@findUsernameByIdUser called"), ["user" => ["id" => $id]]);

        $username = SiprUser::query()
            ->select(["username"])
            ->where('id', "=", $id)
            ->firstOrFail()
            ->username;

        Log::debug(json_encode("SiprUserRepositoryImp@findUsernameByIdUser return"), ["user" => ["username" => $username]]);
        return $username;
    }

    public function findUserById($id): SiprUser
    {
        Log::debug(json_encode("SiprUserRepositoryImp@findUserById called"), ["user" => ["id" => $id]]);
        $user = SiprUser::query()
            ->select(["id", "username", "name", "password", "created_at", "updated_at"])
            ->where("id", "=", $id)
            ->firstOrFail();
        Log::debug(json_encode("SiprUserRepositoryImp@findUserById return"), ["user" => $user]);
        return $user;
    }

    public function findUserByUsername($username): SiprUser
    {
        Log::debug(json_encode("SiprUserRepositoryImp@findUserByUsername called"), ["user" => ["username" => $username]]);
        $user = SiprUser::query()
            ->select(["id", "username", "name", "password", "created_at", "updated_at"])
            ->where('username', "=", $username)
            ->firstOrFail();
        Log::debug(json_encode("SiprUserRepositoryImp@findUserByUsername return"), ["user" => $user]);
        return $user;
    }

    public function updateUserItsNameByUsername($username, $newName): void
    {
        Log::debug(json_encode("SiprUserRepositoryImp@updateUserItsNameByUsername called"), ["user" => ["username" => $username]]);
        $user = SiprUser::query()->select()->where("username", "=", $username)->firstOrFail();
        $user->update([
            "name" => $newName ?? $user->name,
            "updated_at" => Carbon::now(),
        ]);
        $user->save();
    }

    public function updateUserItsNameById($id, $newName): void
    {
        Log::debug(json_encode("SiprUserRepositoryImp@updateUserItsNameById called"), ["user" => ["id" => $id]]);
        $user = SiprUser::query()->select()->where("id", "=", $id)->firstOrFail();
        $user->update([
            "name" => $newName ?? $user->name,
            "updated_at" => Carbon::now(),
        ]);
        $user->save();
    }

    public function updateUserItsUsernameById($id, $newUsername): void
    {
        $user = SiprUser::query()->select()->where("id", "=", $id)->firstOrFail();
        $user->update([
            "username" => $newUsername,
            "updated_at" => Carbon::now(),
        ]);
        $user->save();
    }

    public function deleteUserByUsername($username): int
    {
        Log::debug(json_encode("SiprUserRepositoryImp@deleteUserByUsername called"), ["user" => ["username" => $username]]);
        $user = $this->findUserByUsername($username);
        $deletedUserId = $user["id"];
        SiprUser::query()->where("username", "=", $username)->delete();
        Log::debug(json_encode("SiprUserRepositoryImp@deleteUserByUsername return"), ["user" => ["id" => $deletedUserId]]);
        return $deletedUserId;
    }

    public function deleteUserById($id): int
    {
        Log::debug(json_encode("SiprUserRepositoryImp@deleteUserById called"), ["user" => ["id" => $id]]);
        $user = $this->findUserById($id);
        $deletedUserId = $user["id"];
        Log::debug(json_encode("SiprUserRepositoryImp@deleteUserById return"), ["user" => ["id" => $deletedUserId]]);
        SiprUser::find($deletedUserId)->delete();
        return $deletedUserId;
    }
}
