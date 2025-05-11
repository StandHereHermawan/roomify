<?php

namespace Tests\Feature\Others;

use App\Domains\User\Model\SiprEmail;
use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprUserHasEmail;
use App\Domains\User\Repository\Contracts\SiprUserRepository;
use App\Domains\User\Service\Contracts\SiprPhoneNumberService;
use App\Domains\User\Service\Contracts\SiprUserService;
use App\Domains\User\Service\Contracts\SiprEmailService;
use App\Domains\User\Service\Contracts\SiprRoleService;
use App\Domains\User\Service\Contracts\SiprUserHasEmailService;
use App\Domains\User\Service\Contracts\SiprUserHasPhoneNumberService;
use App\Domains\User\Service\Contracts\SiprUserHasRoleService;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ManyToManyTest extends TestCase
{
    private $tableUser = "sipr_users";

    private $tableEmail = "sipr_emails";

    private $tablePhoneNumber = "sipr_phone_number_contacts";

    private $tableRoles = "sipr_roles";

    private $tableUserHasEmail = "sipr_user_has_emails";

    private $tableUserHasPhoneNumbers = "sipr_user_has_phone_numbers";
    
    private $tableUserHasRoles = "sipr_user_has_roles";

    private SiprUserRepository $siprUserRepository;

    private SiprUserService $siprUserService;

    private SiprEmailService $siprEmailService;

    private SiprPhoneNumberService $siprPhoneNumberService;

    private SiprRoleService $siprRoleService;

    private SiprUserHasEmailService $siprUserHasEmailService;

    private SiprUserHasPhoneNumberService $siprUserHasPhoneNumberService;

    private SiprUserHasRoleService $siprUserHasRoleService;

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();

        DB::statement("DELETE FROM {$this->tableUserHasRoles}");
        DB::statement("ALTER TABLE {$this->tableUserHasRoles} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tableUserHasPhoneNumbers}");
        DB::statement("ALTER TABLE {$this->tableUserHasPhoneNumbers} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tableUserHasEmail}");
        DB::statement("ALTER TABLE {$this->tableUserHasEmail} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tableUser}");
        DB::statement("ALTER TABLE {$this->tableUser} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tableRoles}");
        DB::statement("ALTER TABLE {$this->tableRoles} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tableEmail}");
        DB::statement("ALTER TABLE {$this->tableEmail} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tablePhoneNumber}");
        DB::statement("ALTER TABLE {$this->tablePhoneNumber} AUTO_INCREMENT = 1;");

        $this->siprUserRepository = $this->app->make(SiprUserRepository::class);
        $this->siprUserService = $this->app->make(SiprUserService::class);
        $this->siprEmailService = $this->app->make(SiprEmailService::class);
        $this->siprRoleService = $this->app->make(SiprRoleService::class);
        $this->siprPhoneNumberService = $this->app->make(SiprPhoneNumberService::class);
        $this->siprUserHasEmailService = $this->app->make(SiprUserHasEmailService::class);
        $this->siprUserHasPhoneNumberService = $this->app->make(SiprUserHasPhoneNumberService::class);
        $this->siprUserHasRoleService = $this->app->make(SiprUserHasRoleService::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "ManyToManyTest::testQueryJoinEmail" tests/Feature/
     */
    public function testQueryJoinEmail(): void
    {
        // self::markTestIncomplete("dont know what to do with this unit test.");
        // self::markTestIncomplete("test broken, email service bugs.");

        $userRepository = $this->siprUserRepository;
        $emailService = $this->siprEmailService;
        $userService = $this->siprUserService;

        $userHasEmailService = $this->siprUserHasEmailService;

        $idUser = $userService->createUser("test123", "Test Name", "Rahasia");
        $idEmail1 = $emailService->createEmailAndReturnItsId("Test@localhost.com");
        $idEmail2 = $emailService->createEmailAndReturnItsId("Test1@localhost.com");
        $idRelation1 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail1);
        $idRelation2 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail2);

        $collection = DB::table("sipr_users")
            ->select()
            ->join("sipr_user_has_emails", "sipr_users.id", "=", "sipr_user_has_emails.user_id")
            ->join("sipr_emails", "sipr_user_has_emails.email_id", "=", "sipr_emails.id")
            ->where("sipr_users.id", "=", $idUser)
            ->get()
            ->toArray();

        // echo json_encode($collection, JSON_PRETTY_PRINT);
        self::assertNotNull($collection);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "ManyToManyTest::testManyToManyEloquent" tests/Feature/
     */
    public function testManyToManyEloquent(): void
    {
        // self::markTestIncomplete("dont know what to do with this unit test.");
        // self::markTestIncomplete("test broken, email service bugs.");
        $userService = $this->siprUserService;
        $emailService = $this->siprEmailService;
        $phoneNumberService = $this->siprPhoneNumberService;
        $roleService = $this->siprRoleService;
        $userHasEmailService = $this->siprUserHasEmailService;
        $userHasPhoneNumberService = $this->siprUserHasPhoneNumberService;
        $userHasRoleService = $this->siprUserHasRoleService;

        $idUser = $userService->createUser("test123", "Test Name", "Rahasia");

        $idEmail1 = $emailService->createEmailAndReturnItsId("Test1@localhost.com");
        $idEmail2 = $emailService->createEmailAndReturnItsId("Test2@localhost.com");
        $idEmail3 = $emailService->createEmailAndReturnItsId("Test3@localhost.com");
        $idEmail4 = $emailService->createEmailAndReturnItsId("Test4@localhost.com");

        $idRelationEmail1 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail1);
        $idRelationEmail2 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail2);
        $idRelationEmail3 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail3);
        $idRelationEmail3 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail4);

        $idPhoneNumber1 = $phoneNumberService->createPhoneNumber("+62-812-3456-6789");
        $idPhoneNumber2 = $phoneNumberService->createPhoneNumber("+62-822-3456-6789");
        $idPhoneNumber3 = $phoneNumberService->createPhoneNumber("+62-832-3456-6789");

        $idRelationPhone1 = $userHasPhoneNumberService->createUserHasPhoneNumberRelationship($idUser, $idPhoneNumber1);
        $idRelationPhone2 = $userHasPhoneNumberService->createUserHasPhoneNumberRelationship($idUser, $idPhoneNumber2);
        $idRelationPhone3 = $userHasPhoneNumberService->createUserHasPhoneNumberRelationship($idUser, $idPhoneNumber3);
        
        $idRole1 = $roleService->createRole("Mahasiswa");
        $idRole2 = $roleService->createRole("Member Perpus");
        $idRole3 = $roleService->createRole("Member Hima");

        $idRelationRole1 = $userHasRoleService->createUserHasRoleRelationship($idUser, $idRole1);
        $idRelationRole2 = $userHasRoleService->createUserHasRoleRelationship($idUser, $idRole2);
        $idRelationRole3 = $userHasRoleService->createUserHasRoleRelationship($idUser, $idRole3);

        $user = $userService->findUserModelById($idUser);

        // Many To Many
        $user->getEmails();
        $user->getPhoneNumbers(1);
        $user->getRoles(5);

        // echo PHP_EOL . json_encode($user, JSON_PRETTY_PRINT);

        self::assertNotNull($user);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "ManyToManyTest::testMixed" tests/Feature/
     */
    public function testMixed(): void
    {
        // self::markTestIncomplete("dont know what to do with this unit test.");
        // self::markTestIncomplete("test broken, email service bugs.");
        $userService = $this->siprUserService;
        $emailService = $this->siprEmailService;
        $phoneNumberService = $this->siprPhoneNumberService;
        $roleService = $this->siprRoleService;
        $userHasEmailService = $this->siprUserHasEmailService;
        $userHasPhoneNumberService = $this->siprUserHasPhoneNumberService;
        $userHasRoleService = $this->siprUserHasRoleService;

        $password = "Rahasia123";
        $username = "terry";
        $emailInput1 = "Test1@localhost.com";

        $idUser = $userService->createUser($username, "Test Name", $password);

        $idEmail1 = $emailService->createEmailAndReturnItsId($emailInput1);
        $idEmail2 = $emailService->createEmailAndReturnItsId("Test2@localhost.com");
        $idEmail3 = $emailService->createEmailAndReturnItsId("Test3@localhost.com");
        $idEmail4 = $emailService->createEmailAndReturnItsId("Test4@localhost.com");

        $idRelationEmail1 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail1);
        $idRelationEmail2 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail2);
        $idRelationEmail3 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail3);
        $idRelationEmail4 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail4);

        $user = $userService->findUserModelById($idUser);
        $userModel = SiprUser::select()->where("id", "=", $idUser)->first();
        $userModel->getRoles();
        $userModel->getPhoneNumbers();
        $userModel->getEmails(2,3);
        // var_dump($userModel->hasEmails);
        // var_dump($userModel->hasEmails);
        // echo PHP_EOL . json_encode($userModel, JSON_PRETTY_PRINT);

        self::assertNotNull($user);
    }

/**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "ManyToManyTest::testSomeFunction" tests/Feature/
     */
    public function testSomeFunction(): void
    {
        $userService = $this->siprUserService;
        $emailService = $this->siprEmailService;
        $userHasEmailService = $this->siprUserHasEmailService;
        
        $password = "Rahasia123";
        $username = "terry";
        $emailInput1 = "Test1@localhost.com";

        $idUser = $userService->createUser($username, "Test Name", $password);
        $idEmail1 = $emailService->createEmailAndReturnItsId($emailInput1);
        $idRelationEmail1 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail1);

        $emailModel = SiprEmail::select()->where("email", "=", $emailInput1)->first();
        // var_dump($emailModel);

        $idEmail = null;
        if ($emailModel != null) {
            $idEmail = $emailModel->getId();
        }

        // echo PHP_EOL . json_encode(["idEmail" => $idEmail]);
        
        $userHasEmailModel = SiprUserHasEmail::select()->where("email_id", "=", $idEmail)->first();
        // var_dump($userHasEmailModel);
        
        $userId = null;
        if ($userHasEmailModel != null) {
            $userId = $userHasEmailModel->getUserId() ?? null;
        }
        
        // echo PHP_EOL . json_encode(["userId" => $userId]);
        
        $userModel = SiprUser::select()->where("id", "=", $userId)->first();
        $userModel->getRoles();
        $userModel->getPhoneNumbers();
        $userModel->getEmails();
        // var_dump($userModel);
        // echo PHP_EOL . json_encode($userModel, JSON_PRETTY_PRINT);
        
        $passwordFromDatabase = null;
        if ($userModel != null) {
            $passwordFromDatabase = $userModel->getPassword() ?? null;
        }

        // echo PHP_EOL . json_encode(["passwordFromDatabase" => $passwordFromDatabase]);

        $result = Hash::check($password, $passwordFromDatabase);
        // var_dump($result);

        self::assertNotNull($idEmail);
        self::assertTrue($result);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "ManyToManyTest::testDecryptCookie" tests/Feature/
     */
    public function testDecryptCookie(): void
    {
        // $decryptedXSIPRTOKEN = Crypt::decrypt("eyJpdiI6IktBdVR4NzFCNlZoUnc5RU5RZnIwNGc9PSIsInZhbHVlIjoiNFYySnBneUh0QUI1YjBoZVlpZjAvU2trcEt2ZVB0dXBFRmJVbjdGMFZQQ3huSDFRZTR0WldsdFc5MTE5U2krSSIsIm1hYyI6IjY3OTM2OWZiOTkxYTBlNDk5NzA2YTBiZWNmN2YxY2Y0OWNjOTZjNjYwZGUxMDlmMDg5ODYyM2IxNTg2OTIxMzkiLCJ0YWciOiIifQ==");

        // var_dump($decryptedXSIPRTOKEN);
        // self::assertNotNull($decryptedXSIPRTOKEN);
        self::assertTrue(true);
    }
}
