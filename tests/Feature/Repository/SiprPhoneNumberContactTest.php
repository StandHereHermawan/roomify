<?php

namespace Tests\Feature\Repository;

use Database\Seeders\SiprPhoneNumbersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprPhoneNumberContactTest extends TestCase
{
    private $tableName = "sipr_phone_number_contacts";

    /**
     * 
     * @before
     */
    protected function setUp(): void {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->seed(SiprPhoneNumbersSeeder::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprPhoneNumberContactTest::testSiprPhoneNumberNonORM" tests/Feature/
     */
    public function testSiprPhoneNumberNonORM(): void 
    {
        $collectionOfSiprEmails = DB::table($this->tableName)->select()->get();

        self::assertNotNull($collectionOfSiprEmails);
    }
}
