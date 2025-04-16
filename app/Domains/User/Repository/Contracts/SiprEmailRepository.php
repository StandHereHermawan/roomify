<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprEmailRepository {
    
    public function createEmail($email);

    public function findIdEmailByEmail($email);

    public function findEmailById($id);

    public function updateEmailById($id, $newEmail);

    public function deleteEmailById($id);
}