<?php

namespace Tests\Feature\Service;

use App\Domains\User\Model\SiprUser;
use App\Domains\User\Service\Contracts\SiprUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
     * vendor/bin/phpunit --filter "SiprUserServiceTest::testCreateUserSuccessScenario" tests/Feature/
     */
    public function testCreateUserSuccessScenario(): void
    {
        $idUser = $this->siprUserService->createUser("terry", "Terry", "rahasia");
        self::assertNotNull($idUser);
        self::assertIsInt($idUser);
    }

    

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserServiceTest::testSearchByPasswordCantBecauseBcyrptGenerateDifferentHash" tests/Feature/
     */
    public function testSearchByPasswordCantBecauseBcyrptGenerateDifferentHash(): void
    {
        $password = "Rahasia123";
        $username = "terry";

        $idUser = $this->siprUserService->createUser($username, "Terry", $password);
        
        $userModelSearchWithId = SiprUser::select()->where("id", "=", $idUser)->first();
        // var_dump($userModelSearchWithId->toArray());

        $userModelSearchWithUsername = SiprUser::select()->where("username" ,"=", $username)->first();
        // var_dump($userModelSearchWithUsername->toArray());



        $hashedInputPassword = Hash::make($password);
        // var_dump($hashedInputPassword);

        $userModelSearchWithHashedPassword = SiprUser::select()->where("password", "=", $hashedInputPassword)->first();

        self::assertNotNull($userModelSearchWithId);
        self::assertEquals($userModelSearchWithId, $userModelSearchWithUsername);
        self::assertNotSame($userModelSearchWithId->getPassword(), $hashedInputPassword);
        self::assertNotNull($userModelSearchWithId);
        self::assertNull($userModelSearchWithHashedPassword);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserServiceTest::testMixed" tests/Feature/
     */
    public function testMixed(): void
    {
        $password = "Rahasia123";
        $username = "terry";

        $idUser = $this->siprUserService->createUser($username, "Terry", $password);
        
        self::assertNotNull($idUser);
    }
}
