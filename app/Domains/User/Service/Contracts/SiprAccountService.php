<?php

namespace App\Domains\User\Service\Contracts;

interface SiprAccountService
{

    public function createCompleteAccountWithFields($username, $name, $email, $password, $phoneNumber);
    public function getUserService();
    public function getEmailService();
    public function getPhoneNumberService();
    public function getRoleService();
    public function getUserHasRoleService();
    public function getUserHasEmailService();
    public function getUserHasPhoneNumberService();
}