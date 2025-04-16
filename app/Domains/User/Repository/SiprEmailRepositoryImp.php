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
        Log::debug(json_encode(["newRegisteredEmail" => $email]), ["SiprEmailRepository.createEmail"]);

        SiprEmail::create([
            "email" => $email,
            "created_at" => Carbon::now()
        ]);

        $idEmail = $this->findIdEmailByEmail($email);

        return $idEmail;
    }

    public function findIdEmailByEmail($email): int
    {
        Log::debug(json_encode(["emailToBeFind" => $email]), ["SiprEmailRepository.findIdEmailByEmail"]);

        $emailId = SiprEmail::query()
            ->select(["id"])
            ->where('email', '=', $email)
            ->firstOrFail()
            ->id;

        return $emailId;
    }

    public function findEmailById($id): SiprEmail
    {
        Log::debug(json_encode(["idEmail" => $id]), ["SiprEmailRepository.findIdEmailByEmail"]);

        $email = SiprEmail::query()
            ->select(["id", "email", "created_at", "updated_at"])
            ->where('id', '=', $id)
            ->firstOrFail();

        Log::debug(json_encode(["SiprEmail" => $email]), ["SiprEmailRepository.findIdEmailByEmail"]);

        return $email;
    }

    public function updateEmailById($id, $newEmail)
    {
        Log::debug(json_encode(["idEmail" => $id, "newEmail" => $newEmail]), ["SiprEmailRepository.updateEmailById"]);

        $email = $this->findEmailById($id);

        Log::debug(json_encode(["email" => $email]), ["SiprEmailRepository.updateEmailById.beforeUpdate"]);

        $email->updateOrFail(["email" => $newEmail]);
        
        Log::debug(json_encode(["email" => $email]), ["SiprEmailRepository.updateEmailById.afterUpdate"]);

        $email->save();
    }

    public function deleteEmailById($id) 
    {
        Log::debug(json_encode(["idEmail" => $id]), ["SiprEmailRepository.deleteEmailById"]);

        $emailToBeDeleted = $this->findEmailById($id);
        $emailToBeDeleted->deleteOrFail();
    }
}
