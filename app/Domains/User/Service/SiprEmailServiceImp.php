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


    public function createEmail($email)
    {
        $repository = $this->repository;

        $idEmail = SiprEmail::create([
            "email" => $email,
            "created_at" => Carbon::now()
        ])->getId();

        return $idEmail;
    }

    public function findIdEmailByEmail($email)
    {
        return SiprEmail::select()->where("email", "=", $email)->firstOrFail()->id;
    }

    public function findModelEmailByEmail($email)
    {
        return SiprEmail::select()->where("email", "=", $email)->first();
    }
}
