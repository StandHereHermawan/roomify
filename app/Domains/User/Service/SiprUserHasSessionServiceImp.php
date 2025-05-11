<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprUserHasSessionRepository;
use App\Domains\User\Service\Contracts\SiprUserHasSessionService;
use Illuminate\Support\Facades\Crypt;
use Log;

class SiprUserHasSessionServiceImp implements SiprUserHasSessionService
{
    private SiprUserHasSessionRepository $repository;

    public function __construct(SiprUserHasSessionRepository $variable)
    {
        $this->repository = $variable;
    }

    public function hash256($data)
    {
        return hash('sha256', $data);
    }

    public function createHashedIdUserAndUsername($idUser, $username)
    {
        Log::debug(json_encode("SiprUserHasSessionServiceImp@createHashedIdUserAndUsername called"), ["idUser" => $idUser, "username" => $username]);
        $json = json_encode(["idUser" => $idUser, "username" => $username]);
        $hashed = $this->hash256($json);
        Log::debug(json_encode("SiprUserHasSessionServiceImp@createHashedIdUserAndUsername returned"), ["sessionToken" => $hashed]);
        return $hashed;
    }

    public function createUserHasSession($idUser, $username)
    {
        $repository = $this->repository;
        $json = json_encode(["idUser" => $idUser, "username" => $username]);
        $session = $this->hash256($json);
        return $repository->createUserHasSession($idUser, $username, $session);
    }

    public function createOrFindAndReturnBackUserHasSessionModel($idUser, $username)
    {
        $sessionToken = $this->createHashedIdUserAndUsername($idUser, $username);
        $userHasSessionFromChecking = $this->findUserHasSessionModelBySession($sessionToken);
        if ($userHasSessionFromChecking !== null) {
            return $userHasSessionFromChecking;
        } else {
            return $this->createUserHasSession($idUser, $username);
        }
    }

    public function findIdUserHasSessionByUsername($username)
    {
        $repository = $this->repository;
        return $repository->findIdUserHasSessionByUsername($username);
    }

    public function findSessionByIdUser($idUser)
    {
        $repository = $this->repository;
        return $repository->findSessionByIdUser($idUser);
    }

    public function findUserHasSessionModelByIdUser($idUser)
    {
        $repository = $this->repository;
        return $repository->findUserHasSessionModelByIdUser($idUser);
    }

    public function findUserHasSessionModelBySession($session)
    {
        $repository = $this->repository;
        Log::debug(json_encode("SiprUserHasSessionServiceImp@findUserHasSessionModelBySession called"), ["session" => $session]);
        $userHasSessionModel = $repository->findUserHasSessionModelBySession($session);
        Log::debug(json_encode("SiprUserHasSessionServiceImp@findUserHasSessionModelBySession returned"), ["userHasSessionModel" => $userHasSessionModel]);
        return $userHasSessionModel;
    }
}
