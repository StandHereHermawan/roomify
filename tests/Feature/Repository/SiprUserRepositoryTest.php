<?php

namespace Tests\Feature\Repository;

use App\Models\SiprUser;
use App\Repository\Contracts\SiprUserRepository;
use Database\Seeders\SiprUsersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprUserRepositoryTest extends TestCase
{
    private $tableName = "sipr_users";

    private SiprUserRepository $siprUserRepository;

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->siprUserRepository = $this->app->make(SiprUserRepository::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testCreateUserAndItShouldReturnUserId" tests/Feature/
     */
    public function testCreateUser(): void
    {
        $idUser = $this->siprUserRepository
            ->createUser("terry", "Terry", "rahasia");

        self::assertNotNull($idUser);
        self::assertIsInt($idUser);
         # code
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testFindUserById" tests/Feature/
     */
    public function testFindUserById(): void
    {
        $idUser = $this->siprUserRepository
            ->createUser("terry", "Terry", "rahasia");

        $user = $this->siprUserRepository
            ->findUserById($idUser);

        self::assertNotNull($user);
        self::assertIsInt($idUser);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testFindUserByUsername" tests/Feature/
     */
    public function testFindUserByUsername(): void 
    {
        $this->siprUserRepository
            ->createUser("terry", "Terry", "rahasia");
        $user = $this->siprUserRepository->findUserByUsername("terry");

        self::assertNotNull($user);
    }
}
