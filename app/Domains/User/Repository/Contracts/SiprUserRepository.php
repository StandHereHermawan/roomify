<?php

namespace App\Domains\User\Repository\Contracts;

interface SiprUserRepository {
    
    public function createUser($username, $name, $password);
    
    public function findIdUserByUsername($username);

    public function findUsernameByIdUser($id);

    public function findUserById($id);

    public function findUserByUsername($username);

    public function updateUserItsNameByUsername($username, $newName);

    public function updateUserItsNameById($id, $newName);

    public function updateUserItsUsernameById($id, $newUsername);

    public function deleteUserByUsername($username);

    public function deleteUserById($id);
}