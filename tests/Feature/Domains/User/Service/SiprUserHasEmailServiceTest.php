<?php

namespace Tests\Feature\Service;

use App\Domains\User\Model\SiprUserHasEmail;
use App\Domains\User\Service\Contracts\SiprEmailService;
use App\Domains\User\Service\Contracts\SiprUserHasEmailService;
use App\Domains\User\Service\Contracts\SiprUserService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;

class SiprUserHasEmailServiceTest extends TestCase
{
    private $tableUser = "sipr_users";
    private $tableEmail = "sipr_emails";
    private $tableUserHasEmail = "sipr_user_has_emails";
    private SiprEmailService $siprEmailService;
    private SiprUserService $siprUserService;
    private SiprUserHasEmailService $siprUserHasEmailService;

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

        $this->siprEmailService = $this->app->make(SiprEmailService::class);
        $this->siprUserService = $this->app->make(SiprUserService::class);
        $this->siprUserHasEmailService = $this->app->make(SiprUserHasEmailService::class);
    }


    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasEmailServiceTest::testCreateUserHasEmailRelationship" tests/Feature/
     */
    public function testCreateUserHasEmailRelationship(): void
    {
        $userService = $this->siprUserService;
        $emailService = $this->siprEmailService;
        $userHasEmailService = $this->siprUserHasEmailService;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");

        $idEmail1 = $emailService->createEmailAndReturnItsId("terryExample1@localhost.com");
        $idEmail2 = $emailService->createEmailAndReturnItsId("terryExample2@localhost.com");

        // var_dump($idEmail1);
        // var_dump($idEmail2);

        $idUserHasEmail1 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail1);
        $idUserHasEmail2 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail2);

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
     * vendor/bin/phpunit --filter "SiprUserHasEmailServiceTest::testGetUserIdGetter" tests/Feature/
     */
    public function testGetUserIdGetter(): void
    {
        $userService = $this->siprUserService;
        $emailService = $this->siprEmailService;
        $userHasEmailService = $this->siprUserHasEmailService;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");

        $idEmail1 = $emailService->createEmailAndReturnItsId("terryExample1@localhost.com");
        $idEmail2 = $emailService->createEmailAndReturnItsId("terryExample2@localhost.com");

        // var_dump($idEmail1);
        // var_dump($idEmail2);

        $idUserHasEmail1 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail1);
        $idUserHasEmail2 = $userHasEmailService->createUserHasEmailRelationship($idUser, $idEmail2);

        $x = SiprUserHasEmail::select()->where("email_id", "=", $idEmail2)->first()->getUserId();

        // var_dump($x);

        self::assertNotNull($idUserHasEmail1);
        self::assertNotNull($idUserHasEmail2);
        self::assertIsInt($idUserHasEmail1);
        self::assertIsInt($idUserHasEmail2);
    }
}
