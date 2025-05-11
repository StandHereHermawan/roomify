<?php

namespace App\Domains\User\Service\Contracts;

interface SiprEmailService {

    public function createEmailAndReturnItsId($email);

    public function createEmailAndReturnItsEmailModel($email);
    
    public function findIdEmailByEmail($email);

    public function findEmailModelByEmail($email);
}