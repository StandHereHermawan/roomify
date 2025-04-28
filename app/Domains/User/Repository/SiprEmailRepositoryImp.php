<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprEmail;
use App\Domains\User\Repository\Contracts\SiprEmailRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SiprEmailRepositoryImp implements SiprEmailRepository
{

    public function createEmail($email): int
    {
        $idEmail = SiprEmail::create([
            "email" => $email,
            "created_at" => Carbon::now()
        ])->getId();

        return $idEmail;
    }

    public function findIdEmailByEmail($email): int
    {

        $emailId = SiprEmail::query()
            ->select(["id"])
            ->where('email', '=', $email)
            ->firstOrFail()
            ->getId();

        return $emailId;
    }

    public function findEmailById($id): SiprEmail
    {

        $email = SiprEmail::query()
            ->select(["id", "email", "created_at", "updated_at"])
            ->where('id', '=', $id)
            ->firstOrFail();


        return $email;
    }

    public function updateEmailById($id, $newEmail)
    {
        $email = $this->findEmailById($id);
        $email->updateOrFail(["email" => $newEmail]);
        $email->save();
    }

    public function deleteEmailById($id) 
    {
        $emailToBeDeleted = $this->findEmailById($id);
        $emailToBeDeleted->deleteOrFail();
    }
}
