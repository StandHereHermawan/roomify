<?php

namespace Tests\Feature\Repository;

use App\Domains\User\Model\SiprUser;
use App\Domains\User\Repository\Contracts\SiprUserRepository;
use Database\Seeders\SiprUsersSeeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testCreateUserSuccessScenario" tests/Feature/
     */
    public function testCreateUserSuccessScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        self::assertNotNull($idUser);
        self::assertIsInt($idUser);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testGetIdUserByUsernameSuccessScenario" tests/Feature/
     */
    public function testGetIdUserByUsernameSuccessScenario(): void
    {
        $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        $idUser = $this->siprUserRepository->findIdUserByUsername("terry");

        self::assertNotNull($idUser);
        self::assertIsInt($idUser);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testGetIdUserByUsernameFailedScenario" tests/Feature/
     */
    public function testGetIdUserByUsernameFailedScenario(): void
    {
        self::expectException(ModelNotFoundException::class);
        $this->siprUserRepository->findIdUserByUsername("oke");

        self::markTestIncomplete("not yet implemented!");
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testGetUsernameByIdUserSuccessScenario" tests/Feature/
     */
    public function testGetUsernameByIdUserSuccessScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        $username = $this->siprUserRepository->findUsernameByIdUser($idUser);

        self::assertNotNull($username);
        self::assertNotNull($idUser);
        self::assertIsInt($idUser);
        self::assertIsString($username);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testGetUsernameByIdUserFailedScenario" tests/Feature/
     */
    public function testGetUsernameByIdUserFailedScenario(): void
    {
        self::expectException(ModelNotFoundException::class);
        $this->siprUserRepository->findUsernameByIdUser(1);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testGetUserByIdSuccessScenario" tests/Feature/
     */
    public function testGetUserByIdSuccessScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        $user = $this->siprUserRepository->findUserById($idUser);

        self::assertNotNull($user);
        self::assertNotNull($idUser);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testGetUserByIdFailedScenario" tests/Feature/
     */
    public function testGetUserByIdFailedScenario(): void
    {
        self::expectException(ModelNotFoundException::class);
        $this->siprUserRepository->findUserById(1);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testGetUserByUsernameSuccessScenario" tests/Feature/
     */
    public function testGetUserByUsernameSuccessScenario(): void
    {
        $this->siprUserRepository->createUser("terry", "Terry", "rahasia");

        $user = $this->siprUserRepository->findUserByUsername("terry");

        self::assertNotNull($user);
        self::assertNotNull($user->id);
        self::assertNotNull($user->name);
        self::assertNotNull($user->username);
        self::assertNotNull($user->password);
        self::assertNotNull($user->created_at);
        self::assertNull($user->updated_at);
        self::assertInstanceOf(SiprUser::class, $user);
        self::assertTrue(Hash::check("rahasia", $user->password,));
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testGetUserByUsernameFailedScenario" tests/Feature/
     */
    public function testGetUserByUsernameFailedScenario(): void
    {
        self::expectException(ModelNotFoundException::class);
        $this->siprUserRepository->findUserByUsername("terry");

        self::markTestIncomplete("not yet implemented!");
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testUpdateUserItsNameByUsernameSuccessScenario" tests/Feature/
     */
    public function testUpdateUserItsNameByUsernameSuccessScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        $notUpdatedUser = $this->siprUserRepository->findUserByUsername("terry");

        $this->siprUserRepository->updateUserItsNameByUsername("terry", "Terry Davis");
        $updatedUser = $this->siprUserRepository->findUserByUsername("terry");

        self::assertEquals($notUpdatedUser->id, $updatedUser->id);
        self::assertEquals($notUpdatedUser->id, $idUser);
        self::assertEquals($updatedUser->id, $idUser);
        self::assertNotEquals($notUpdatedUser->name, $updatedUser->name);
        self::assertInstanceOf(SiprUser::class, $notUpdatedUser);
        self::assertInstanceOf(SiprUser::class, $updatedUser);
        self::assertNotNull($updatedUser->updated_at);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testUpdateUserItsNameByUsernameFailedScenario" tests/Feature/
     */
    public function testUpdateUserItsNameByUsernameFailedScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");

        self::markTestIncomplete("not yet implemented!");
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testUpdateUserItsNameByIdSuccessScenario" tests/Feature/
     */
    public function testUpdateUserItsNameByIdSuccessScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        $notUpdatedUser = $this->siprUserRepository->findUserById($idUser);

        $this->siprUserRepository->updateUserItsNameById($idUser, "Terry Davis");
        $updatedUser = $this->siprUserRepository->findUserById($idUser);

        self::assertEquals($notUpdatedUser->id, $updatedUser->id);
        self::assertEquals($notUpdatedUser->id, $idUser);
        self::assertEquals($updatedUser->id, $idUser);
        self::assertNotEquals($notUpdatedUser->name, $updatedUser->name);
        self::assertInstanceOf(SiprUser::class, $notUpdatedUser);
        self::assertInstanceOf(SiprUser::class, $updatedUser);
        self::assertNotNull($updatedUser->updated_at);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testUpdateUserItsNameByIdFailedScenario" tests/Feature/
     */
    public function testUpdateUserItsNameByIdFailedScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");

        self::markTestIncomplete("not yet implemented!");
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testUpdateUserItsUsernameByIdSuccessScenario" tests/Feature/
     */
    public function testUpdateUserItsUsernameByIdSuccessScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        $notUpdatedUser = $this->siprUserRepository->findUserById($idUser);

        $this->siprUserRepository->updateUserItsUsernameById($idUser, "terry_here");
        $updatedUser = $this->siprUserRepository->findUserById($idUser);

        self::assertEquals($notUpdatedUser->id, $updatedUser->id);
        self::assertEquals($notUpdatedUser->id, $idUser);
        self::assertEquals($updatedUser->id, $idUser);
        self::assertNotEquals($notUpdatedUser->username, $updatedUser->username);
        self::assertInstanceOf(SiprUser::class, $notUpdatedUser);
        self::assertInstanceOf(SiprUser::class, $updatedUser);
        self::assertNotNull($updatedUser->updated_at);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testUpdateUserItsUsernameByIdFailedScenario" tests/Feature/
     */
    public function testUpdateUserItsUsernameByIdFailedScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");

        self::markTestIncomplete("not yet implemented!");
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testDeleteUserByIdSuccessScenario" tests/Feature/
     */
    public function testDeleteUserByIdSuccessScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        $this->siprUserRepository->deleteUserById($idUser);

        self::expectException(ModelNotFoundException::class);
        $notFound = $this->siprUserRepository->findUserById($idUser);

        self::assertEquals(null, $notFound);
        self::assertNull($notFound);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testDeleteUserByIdFailedScenario" tests/Feature/
     */
    public function testDeleteUserByIdFailedScenario(): void
    {
        $service = $this->siprUserRepository;

        self::expectException(ModelNotFoundException::class);
        $service->deleteUserById("1");
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testDeleteUserByUsernameSuccessScenario" tests/Feature/
     */
    public function testDeleteUserByUsernameSuccessScenario(): void
    {
        $idUser = $this->siprUserRepository->createUser("terry", "Terry", "rahasia");
        $username = $this->siprUserRepository->findUsernameByIdUser($idUser);

        $this->siprUserRepository->deleteUserByUsername($username);

        self::expectException(ModelNotFoundException::class);
        $notFound = $this->siprUserRepository->findUserById($idUser);

        self::assertEquals(null, $notFound);
        self::assertNull($notFound);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testDeleteUserByUsernameFailedScenario" tests/Feature/
     */
    public function testDeleteUserByUsernameFailedScenario(): void
    {
        $service = $this->siprUserRepository;

        self::expectException(ModelNotFoundException::class);
        $service->deleteUserByUsername("Eko");
    }
}
