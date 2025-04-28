<?php

namespace App\Domains\User\Service\Contracts;

interface SiprUserHasSessionService
{
    public function createUserHasSession($idUser, $username);

    public function findIdUserHasSessionByUsername($username);

    public function findSessionByIdUser($idUser);

    public function findUserHasSessionModelByIdUser($idUser);

    // public function createLoginToken($idUser, $username);
}
