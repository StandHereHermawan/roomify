<?php

namespace App\Domains\User\Service;

use App\Domains\User\Service\Contracts\SiprAccountService;
use App\Domains\User\Service\Contracts\SiprEmailService;
use App\Domains\User\Service\Contracts\SiprPhoneNumberService;
use App\Domains\User\Service\Contracts\SiprRoleService;
use App\Domains\User\Service\Contracts\SiprUserHasEmailService;
use App\Domains\User\Service\Contracts\SiprUserHasPhoneNumberService;
use App\Domains\User\Service\Contracts\SiprUserHasRoleService;
use App\Domains\User\Service\Contracts\SiprUserHasSessionService;
use App\Domains\User\Service\Contracts\SiprUserService;
use DB;

class SiprAccountServiceImp implements SiprAccountService
{

    private SiprUserService $siprUserService;
    private SiprEmailService $siprEmailService;
    private SiprRoleService $siprRoleService;
    private SiprPhoneNumberService $siprPhoneNumberService;
    private SiprUserHasRoleService $siprUserHasRoleService;
    private SiprUserHasEmailService $siprUserHasEmailService;
    private SiprUserHasPhoneNumberService $siprUserHasPhoneNumberService;
    private SiprUserHasSessionService $siprUserHasSessionService;

    public function __construct(
        SiprUserService $siprUserService,
        SiprEmailService $siprEmailService,
        SiprPhoneNumberService $siprPhoneNumberService,
        SiprRoleService $siprRoleService,
        SiprUserHasRoleService $siprUserHasRoleService,
        SiprUserHasEmailService $siprUserHasEmailService,
        SiprUserHasPhoneNumberService $siprUserHasPhoneNumberService,
        SiprUserHasSessionService $siprUserHasSessionService,
    ) {
        $this->siprUserService = $siprUserService;
        $this->siprEmailService = $siprEmailService;
        $this->siprPhoneNumberService = $siprPhoneNumberService;
        $this->siprRoleService = $siprRoleService;
        $this->siprUserHasRoleService = $siprUserHasRoleService;
        $this->siprUserHasEmailService = $siprUserHasEmailService;
        $this->siprUserHasPhoneNumberService = $siprUserHasPhoneNumberService;
        $this->siprUserHasSessionService = $siprUserHasSessionService;
    }

    public function getUserService()
    {
        return $this->siprUserService;
    }

    public function getEmailService()
    {
        return $this->siprEmailService;
    }

    public function getPhoneNumberService()
    {
        return $this->siprPhoneNumberService;
    }

    public function getRoleService()
    {
        return $this->siprRoleService;
    }

    public function getUserHasRoleService()
    {
        return $this->siprUserHasRoleService;
    }

    public function getUserHasEmailService()
    {
        return $this->siprUserHasEmailService;
    }

    public function getUserHasPhoneNumberService()
    {
        return $this->siprUserHasPhoneNumberService;
    }

    public function getUserHasSessionService()
    {
        return $this->siprUserHasSessionService;
    }

    public function createCompleteAccountWithFields($username, $name, $email, $password, $phoneNumber)
    {
        $userService = $this->siprUserService;
        $roleService = $this->siprRoleService;
        $emailService = $this->siprEmailService;
        $phoneNumberService = $this->siprPhoneNumberService;
        $userHasRoleService = $this->siprUserHasRoleService;
        $userHasEmailService = $this->siprUserHasEmailService;
        $userHasPhoneNumberService = $this->siprUserHasPhoneNumberService;


        DB::transaction(function () use ($userService, $roleService, $emailService, $phoneNumberService, $userHasRoleService, $userHasEmailService, $userHasPhoneNumberService, $username, $name, $email, $password, $phoneNumber) {
            $idUser = $userService->createUser(
                $username,
                $name,
                $password
            );

            $idEmail = $emailService->createEmailAndReturnItsId(
                $email
            );

            $idPhone = $phoneNumberService->createPhoneNumber(
                $phoneNumber,
            );

            $userHasEmailService->createUserHasEmailRelationship(
                $idUser,
                $idEmail
            );

            $userHasPhoneNumberService->createUserHasPhoneNumberRelationship(
                $idUser,
                $idPhone
            );
        });
    }
}
