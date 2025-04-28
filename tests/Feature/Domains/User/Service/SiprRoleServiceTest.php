<?php

namespace Tests\Feature\Domains\User\Service;

use App\Domains\User\Service\Contracts\SiprRoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprRoleServiceTest extends TestCase
{
    private $tableName = "sipr_roles";

    private SiprRoleService $service;

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->service = $this->app->make(SiprRoleService::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprRoleServiceTest::testCreateRole" tests/Feature/
     */
    public function testCreateRole(): void 
    {
        $service = $this->service;

        $idPhone = $service->createRole("Mahasiswa");

        self::assertNotNull($idPhone);
        self::assertIsInt($idPhone);
    }
}
