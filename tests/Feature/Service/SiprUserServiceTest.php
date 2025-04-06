<?php

namespace Tests\Feature\Service;

use App\Service\Contracts\SiprUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprUserServiceTest extends TestCase
{
    private $tableName = "sipr_users";

    private SiprUserService $siprUserService;

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->siprUserService = $this->app->make(SiprUserService::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserServiceTest::testCreateUser" tests/Feature/
     */
    public function testCreateUser(): void 
    {
        $idUser = $this->siprUserService->createUser("terry", "Terry", "rahasia");
        self::assertNotNull($idUser);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserServiceTest::testGetUserById" tests/Feature/
     */
    public function testGetUserById(): void 
    {
        $idUser = $this->siprUserService->createUser("terry", "Terry", "rahasia");
        $user = $this->siprUserService->getUserById($idUser);

        self::assertNotNull($user);
    }
}
