<?php

namespace Tests\Feature\Domains\User\Service;

use App\Domains\User\Service\Contracts\SiprPhoneNumberContactService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprPhoneNumberServiceTest extends TestCase
{
    private $tableName = "sipr_phone_number_contacts";

    private SiprPhoneNumberContactService $service;

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->service = $this->app->make(SiprPhoneNumberContactService::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprPhoneNumberContactsService::testCreatePhoneNumberSuccessScenario" tests/Feature/
     */
    public function testCreatePhoneNumberSuccessScenario(): void 
    {
        $service = $this->service;

        $idPhone = $service->createPhoneNumber("+62-812-3456-7890");

        self::assertNotNull($idPhone);
        self::assertIsInt($idPhone);
    }
}
