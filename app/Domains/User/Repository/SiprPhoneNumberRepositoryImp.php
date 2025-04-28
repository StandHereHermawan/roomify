<?php

namespace App\Domains\User\Repository;

use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Repository\Contracts\SiprPhoneNumberRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SiprPhoneNumberRepositoryImp implements SiprPhoneNumberRepository {

    public function createPhoneNumber($phoneNumber): int
    {
        Log::debug(json_encode(["newRegisteredEmail" => $phoneNumber]), ["SiprPhoneNumberRepository.createEmail"]);

        SiprPhoneNumber::create([
            "phone_number" => $phoneNumber,
            "created_at" => Carbon::now()
        ]);

        $idEmail = $this->findIdPhoneNumberByPhoneNumber($phoneNumber);

        return $idEmail;
    }

    public function findIdPhoneNumberByPhoneNumber($phoneNumber): int
    {
        Log::debug(json_encode(["emailToBeFind" => $phoneNumber]), ["SiprPhoneNumberRepository.findIdEmailByEmail"]);

        $phoneNumberId = SiprPhoneNumber::query()
            ->select(["id"])
            ->where('phone_number', '=', $phoneNumber)
            ->firstOrFail()
            ->id;

        return $phoneNumberId;
    }
}