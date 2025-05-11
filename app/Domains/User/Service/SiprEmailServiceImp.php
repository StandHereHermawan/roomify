<?php

namespace App\Domains\User\Service;

use App\Domains\User\Model\SiprEmail;
use App\Domains\User\Repository\Contracts\SiprEmailRepository;
use App\Domains\User\Service\Contracts\SiprEmailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SiprEmailServiceImp implements SiprEmailService
{
    private SiprEmailRepository $repository;

    public function __construct(SiprEmailRepository $variable)
    {
        $this->repository = $variable;
    }


    public function createEmailAndReturnItsId($email)
    {
        $repository = $this->repository;

        $idEmail = SiprEmail::create([
            "email" => $email,
            "created_at" => Carbon::now()
        ])->getId();

        return $idEmail;
    }

    public function createEmailAndReturnItsEmailModel($email)
    {
        Log::debug(json_encode("SiprEmailServiceImp@createEmailAndReturnItsEmailModel called"), ["email" => $email]);
        $emailModel = $this->repository->createEmailAndReturnItsEmailModel($email);
        Log::debug(json_encode("SiprEmailServiceImp@createEmailAndReturnItsEmailModel returned"), ["emailModel" => $emailModel]);
        return $emailModel;
    }

    public function findIdEmailByEmail($email)
    {
        return SiprEmail::select()->where("email", "=", $email)->firstOrFail()->id;
    }

    public function findEmailModelByEmail($email)
    {
        Log::debug(json_encode("SiprEmailServiceImp@findEmailModelByEmail called"), ["email" => $email]);
        $emailModel = $this->repository->findEmailModelByEmail($email);
        Log::debug(json_encode("SiprEmailServiceImp@findEmailModelByEmail returned"), ["emailModel" => $emailModel]);
        return $emailModel;
    }
}
