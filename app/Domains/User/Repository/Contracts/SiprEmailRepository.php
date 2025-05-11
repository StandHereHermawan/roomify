<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprEmailRepository
{

    public function createEmailAndReturnItsId($email);

    public function createEmailAndReturnItsEmailModel($email);

    public function findIdEmailByEmail($email);

    public function findEmailModelById($id);

    public function findEmailModelByEmail($email);

    public function updateEmailById($id, $newEmail);

    public function deleteEmailById($id);
}