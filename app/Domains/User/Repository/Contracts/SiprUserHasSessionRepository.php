<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprUserHasSessionRepository
{

    public function createUserHasSession($idUser, $username, $session);
    public function findSessionByIdUser($idUser);
    public function findIdUserHasSessionByUsername($username);
    public function findUserHasSessionModelByIdUser($idUser);
    public function findUserHasSessionModelBySession($session);
}