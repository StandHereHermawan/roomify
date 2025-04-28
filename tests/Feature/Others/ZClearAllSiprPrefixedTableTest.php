<?php

namespace Tests\Feature\Others;

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
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ZClearAllSiprPrefixedTableTest extends TestCase
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
     * vendor/bin/phpunit --filter "ZClearAllSiprPrefixedTable::testAssertTrue" tests/Feature/
     */
    public function testAssertTrue(): void
    {
        // echo json_encode($collection, JSON_PRETTY_PRINT);
        self::assertTrue(true);
    }
}
