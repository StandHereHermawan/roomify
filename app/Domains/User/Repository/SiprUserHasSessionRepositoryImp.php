<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprUserHasSession;

use App\Domains\User\Repository\Contracts\SiprUserHasSessionRepository;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SiprUserHasSessionRepositoryImp implements SiprUserHasSessionRepository
{

    public function createUserHasSession($idUser, $username, $session)
    {
        Log::debug(json_encode("SiprUserHasSessionRepositoryImp@createUserHasSession called"), ["idUser" => $idUser, "username" => $username, "session" => $session,]);
        $userHasSessionModel = SiprUserHasSession::create([
            "user_id" => $idUser,
            "username" => $username,
            "session" => $session,
            "created_at" => Carbon::now(),
            "expired_at" => Carbon::now()->addDays(7),
        ]);
        Log::debug(json_encode("SiprUserHasSessionRepositoryImp@createUserHasSession returned"), ["userHasSessionModel" => $userHasSessionModel]);
        return $userHasSessionModel;
    }

    public function findIdUserHasSessionByUsername($username)
    {
        $idUserHasRole = SiprUserHasSession::query()
            ->select(["id"])
            ->where('username', "=", $username)
            ->firstOrFail()
            ->id;
        return $idUserHasRole;
    }

    public function findSessionByIdUser($idUser)
    {
        $session = SiprUserHasSession::query()
            ->select(["session"])
            ->where('user_id', "=", $idUser)
            ->firstOrFail()
            ->session;
        return $session;
    }

    public function findUserHasSessionModelByIdUser($idUser)
    {
        return SiprUserHasSession::query()
            ->select()
            ->where('user_id', "=", $idUser)
            ->first()
        ;
    }

    public function findUserHasSessionModelBySession($session)
    {
        Log::debug(json_encode("SiprUserHasSessionRepositoryImp@findUserHasSessionModelBySession called"), ["session" => $session]);
        $userHasSessionModel = SiprUserHasSession::select()
            ->where("session", "=", $session)
            ->first();
        Log::debug(json_encode("SiprUserHasSessionRepositoryImp@findUserHasSessionModelBySession returned"), ["userHasSessionModel" => $userHasSessionModel]);
        return $userHasSessionModel;
    }
}
