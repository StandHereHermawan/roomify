<?php

namespace Tests\Feature\Service;

use App\Domains\User\Service\Contracts\SiprPhoneNumberService;
use App\Domains\User\Service\Contracts\SiprUserHasPhoneNumberService;
use App\Domains\User\Service\Contracts\SiprUserService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;

class SiprUserHasPhoneNumberServiceTest extends TestCase
{
    private $tableUser = "sipr_users";
    private $tableEmail = "sipr_phone_number_contacts";
    private $tableUserHasEmail = "sipr_user_has_phone_numbers";
    private SiprPhoneNumberService $siprPhoneNumberService;
    private SiprUserService $siprUserService;
    private SiprUserHasPhoneNumberService $siprUserHasEmailService;

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();

        DB::statement("DELETE FROM {$this->tableUserHasEmail}");
        DB::statement("ALTER TABLE {$this->tableUserHasEmail} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tableUser}");
        DB::statement("ALTER TABLE {$this->tableUser} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tableEmail}");
        DB::statement("ALTER TABLE {$this->tableEmail} AUTO_INCREMENT = 1;");

        $this->siprPhoneNumberService = $this->app->make(SiprPhoneNumberService::class);
        $this->siprUserService = $this->app->make(SiprUserService::class);
        $this->siprUserHasEmailService = $this->app->make(SiprUserHasPhoneNumberService::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasPhoneNumberServiceTest::testCreateUserHasPhoneNumberRelationship" tests/Feature/
     */
    public function testCreateUserHasPhoneNumberRelationship(): void
    {
        $userService = $this->siprUserService;
        $phoneNumberService = $this->siprPhoneNumberService;
        $userHasEmailService = $this->siprUserHasEmailService;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");
        
        $idPhoneNumber1 = $phoneNumberService->createPhoneNumber("+62-812-3456-7890");
        $idPhoneNumber2 = $phoneNumberService->createPhoneNumber("+62-822-3456-7890");

        $idUserHasEmail1 = $userHasEmailService->createUserHasPhoneNumberRelationship($idUser, $idPhoneNumber1);
        $idUserHasEmail2 = $userHasEmailService->createUserHasPhoneNumberRelationship($idUser, $idPhoneNumber2);
    
        self::assertNotNull($idUserHasEmail1);
        self::assertNotNull($idUserHasEmail2);
        self::assertIsInt($idUserHasEmail1);
        self::assertIsInt($idUserHasEmail2);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasPhoneNumberServiceTest::testfindPhoneNumberIdByUserHasPhoneNumberContactRelationshipId" tests/Feature/
     */
    public function testfindPhoneNumberIdByUserHasPhoneNumberContactRelationshipId(): void
    {
        $userService = $this->siprUserService;
        $phoneNumberService = $this->siprPhoneNumberService;
        $userHasEmailService = $this->siprUserHasEmailService;

        $idUser1 = $userService->createUser("terry123", "Terry Davis", "Rahasia");
        $idUser2 = $userService->createUser("terry1234", "Andrew Davis", "Rahasia");
        
        $idPhoneNumber1 = $phoneNumberService->createPhoneNumber("+62-812-3456-7890");
        $idPhoneNumber2 = $phoneNumberService->createPhoneNumber("+62-822-3456-7890");
        $idPhoneNumber3 = $phoneNumberService->createPhoneNumber("+62-832-3456-7890");

        $idUserHasEmail1 = $userHasEmailService->createUserHasPhoneNumberRelationship($idUser1, $idPhoneNumber1);
        $idUserHasEmail2 = $userHasEmailService->createUserHasPhoneNumberRelationship($idUser1, $idPhoneNumber2);
        $idUserHasEmail3 = $userHasEmailService->createUserHasPhoneNumberRelationship($idUser1, $idPhoneNumber3);
        $idUserHasEmail4 = $userHasEmailService->createUserHasPhoneNumberRelationship($idUser2, $idPhoneNumber3);

        $phoneNumberId1 = $userHasEmailService->findPhoneNumberIdByUserHasPhoneNumberContactRelationShipId($idUserHasEmail1);
        $phoneNumberId2 = $userHasEmailService->findPhoneNumberIdByUserHasPhoneNumberContactRelationShipId($idUserHasEmail2);

        self::assertNotNull($phoneNumberId1);
        self::assertNotNull($phoneNumberId2);
        self::assertSame($phoneNumberId1, $idPhoneNumber1);
        self::assertSame($phoneNumberId2, $idPhoneNumber2);
    }
}
