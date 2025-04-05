<?php

namespace Tests\Feature\Repository;

use Database\Seeders\SiprEmailsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprEmailTest extends TestCase
{
    private $tableName = "sipr_emails";

    /**
     * 
     * @before
     */
    protected function setUp(): void {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->seed(SiprEmailsSeeder::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailTest::testSiprEmailNonORM" tests/Feature/
     */
    public function testSiprEmailNonORM(): void 
    {
        $collectionOfSiprEmails = DB::table($this->tableName)->select()->get();

        self::assertNotNull($collectionOfSiprEmails);
    }
}
