<?php

namespace App\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprUserHasSessionRepository;
use App\Domains\User\Service\Contracts\SiprUserHasSessionService;
use Illuminate\Support\Facades\Crypt;

class SiprUserHasSessionServiceImp implements SiprUserHasSessionService
{
    private SiprUserHasSessionRepository $repository;

    public function __construct(SiprUserHasSessionRepository $variable)
    {
        $this->repository = $variable;
    }

    private function hash256($data)
    {
        return hash('sha256', $data);
    }

    public function createUserHasSession($idUser, $username)
    {
        $repository = $this->repository;
        $json = json_encode(["idUser" => $idUser, "username" => $username]);
        $session = $this->hash256($json);
        return $repository->createUserHasSession($idUser, $username, $session);
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

    // public function createLoginToken($idUser, $username)
    // {
        // $this->createUserHasSession($idUser, $username);
    // 
        // $model = $this->findUserHasSessionModelByIdUser($idUser);
        // $toBeEncrypted = $model->getIdUserAndUsernameAndSessionAndExpiredAtAsArray();
    // 
        // return Crypt::encrypt($toBeEncrypted);
    // }
}
