<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprEmail;
use App\Domains\User\Repository\Contracts\SiprEmailRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SiprEmailRepositoryImp implements SiprEmailRepository
{

    public function createEmailAndReturnItsId($email): int
    {
        Log::debug(json_encode("SiprEmailRepositoryImp@createEmailAndReturnItsId called"), ["email" => $email]);
        $idEmail = SiprEmail::create([
            "email" => $email,
            "created_at" => Carbon::now()
        ])->getId();
        Log::debug(json_encode("SiprEmailRepositoryImp@createEmailAndReturnItsId returned"), ["idEmail" => $idEmail]);
        return $idEmail;
    }

    public function createEmailAndReturnItsEmailModel($email): SiprEmail
    {
        Log::debug(json_encode("SiprEmailRepositoryImp@createEmailAndReturnItsId called"), ["email" => $email]);
        $emailModel = SiprEmail::create([
            "email" => $email,
            "created_at" => Carbon::now()
        ]);
        Log::debug(json_encode("SiprEmailRepositoryImp@createEmailAndReturnItsId returned"), ["emailModel" => $emailModel]);
        return $emailModel;
    }

    public function findIdEmailByEmail($email): int
    {
        Log::debug(json_encode("SiprEmailRepositoryImp@findIdEmailByEmail called"), ["email" => $email]);
        $emailId = SiprEmail::query()
            ->select(["id"])
            ->where('email', '=', $email)
            ->firstOrFail()
            ->getId();
        Log::debug(json_encode("SiprEmailRepositoryImp@findIdEmailByEmail returned"), ["emailId" => $emailId]);
        return $emailId;
    }

    public function findEmailModelById($id): SiprEmail
    {

        $email = SiprEmail::query()
            ->select(["id", "email", "created_at", "updated_at"])
            ->where('id', '=', $id)
            ->firstOrFail();


        return $email;
    }

    public function findEmailModelByEmail($email)
    {
        Log::debug(json_encode("SiprEmailRepositoryImp@findEmailModelByEmail called"), ["email" => $email]);
        $emailModel = SiprEmail::select()->where("email", "=", $email)->first();
        Log::debug(json_encode("SiprEmailRepositoryImp@findEmailModelByEmail returned"), ["emailModel" => $emailModel]);
        return $emailModel;
    }

    public function updateEmailById($id, $newEmail)
    {
        $email = $this->findEmailModelById($id);
        $email->updateOrFail(["email" => $newEmail]);
        $email->save();
    }

    public function deleteEmailById($id)
    {
        $emailToBeDeleted = $this->findEmailModelById($id);
        $emailToBeDeleted->deleteOrFail();
    }

}
