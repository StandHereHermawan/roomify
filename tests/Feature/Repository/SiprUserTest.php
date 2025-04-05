<?php

namespace Tests\Feature\Repository;

use Database\Seeders\SiprUsersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprUserTest extends TestCase
{
    private $tableName = "sipr_users";

    /**
     * 
     * @before
     */
    protected function setUp(): void {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->seed(SiprUsersSeeder::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserTest::testSiprUsersNonORM" tests/Feature/
     */
    public function testSiprUsersNonORM(): void 
    {
        $collectionOfSiprUsers = DB::table($this->tableName)->select()->get();

        self::assertNotNull($collectionOfSiprUsers);
    }
}
