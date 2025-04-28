<?php

namespace Tests\Feature\Domains\User\Service;

use App\Domains\User\Model\SiprUserHasSession;
use App\Domains\User\Service\Contracts\SiprUserHasSessionService;
use App\Domains\User\Service\Contracts\SiprUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprUserHasSessionServiceTest extends TestCase
{
    private $tableUser = "sipr_users";
    private $tableUserHasSession = "sipr_user_has_sessions";
    private SiprUserService $siprUserService;
    private SiprUserHasSessionService $siprUserHasSessionService;

    private function hashAlgoSha256($data)
    {
        return hash('sha256', $data);
    }

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();

        DB::statement("DELETE FROM {$this->tableUser}");
        DB::statement("ALTER TABLE {$this->tableUser} AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM {$this->tableUserHasSession}");
        DB::statement("ALTER TABLE {$this->tableUserHasSession} AUTO_INCREMENT = 1;");

        $this->siprUserService = $this->app->make(SiprUserService::class);
        $this->siprUserHasSessionService = $this->app->make(SiprUserHasSessionService::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasSessionServiceTest::testCreateUserHasSession" tests/Feature/
     */
    public function testCreateUserHasSession(): void
    {
        $userService = $this->siprUserService;
        $userHasSessionService = $this->siprUserHasSessionService;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");
        $user = $userService->findUserById($idUser);

        $idUser = $user->getId();
        $username = $user->getUsername();
        // $user->getName();

        // var_dump($idUser);
        // var_dump($username);
        // var_dump($name);

        $userHasSessionService->createUserHasSession($idUser, "terry123");
        $session = $userHasSessionService->findSessionByIdUser($idUser);

        $json = json_encode(["idUser" => $idUser, "username" => $username]);
        $hashedIduserAndUsername = self::hashAlgoSha256($json);

        // var_dump($session);
        // var_dump($hashedIduserAndUsername);

        // $user->getSession();        
        // $user = json_encode($user, JSON_PRETTY_PRINT);
        // var_dump($user);

        self::assertNotNull($session);
        self::assertEquals($session, $hashedIduserAndUsername);
        self::assertNotNull($idUser);
        self::assertIsInt($idUser);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasSessionServiceTest::testFindUserHasSessionModelByIdUser" tests/Feature/
     */
    public function testFindUserHasSessionModelByIdUser(): void
    {
        $userService = $this->siprUserService;
        $userHasSessionService = $this->siprUserHasSessionService;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");
        $userHasSessionService->createUserHasSession($idUser, "terry123");

        $userHasSessionModel = $userHasSessionService->findUserHasSessionModelByIdUser($idUser);

        $idUserFromUserHasSessionModel = $userHasSessionModel->getIdUser();
        $usernameFromUserHasSessionModel = $userHasSessionModel->getUsername();
        $sessionFromUserHasSessionModel = $userHasSessionModel->getSession();

        // var_dump($idUserFromUserHasSessionModel);
        // var_dump($usernameFromUserHasSessionModel);
        // var_dump($sessionFromUserHasSessionModel);

        self::assertNotNull($idUserFromUserHasSessionModel);
        self::assertNotNull($usernameFromUserHasSessionModel);
        self::assertNotNull($sessionFromUserHasSessionModel);

        self::assertNotNull($userHasSessionModel);
        self::assertInstanceOf(SiprUserHasSession::class, $userHasSessionModel);
        self::assertNotNull($idUser);
        self::assertIsInt($idUser);
        
        $userHasSessionModel = json_encode($userHasSessionModel, JSON_PRETTY_PRINT);
        self::assertIsString($userHasSessionModel);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasSessionServiceTest::testEncryptDecryptArray" tests/Feature/
     */
    public function testEncryptDecryptArray(): void
    {
        $userService = $this->siprUserService;
        $userHasSessionService = $this->siprUserHasSessionService;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");
        $idUserHasSession = $userHasSessionService->createUserHasSession($idUser, "terry123");

        $userHasSessionModel = $userHasSessionService->findUserHasSessionModelByIdUser($idUser);

        $array = $userHasSessionModel->getIdUserAndUsernameAndSessionAndExpiredAtAsArray();

        $encryptedArray = Crypt::encrypt($array);
        $decryptedArray = Crypt::decrypt($encryptedArray);

        // var_dump($array);
        // var_dump($encryptedArray);
        // var_dump($decryptedArray);

        self::assertNotNull($idUser);
        self::assertNotNull($idUserHasSession);
        self::assertNotNull($userHasSessionModel);
        self::assertIsInt($idUser);
        self::assertEquals($array, $decryptedArray);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasSessionServiceTest::testCreateToken" tests/Feature/
     */
    public function testCreateToken(): void
    {
        $userService = $this->siprUserService;
        $userHasSessionService = $this->siprUserHasSessionService;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");
        // $encryptedArray = $userHasSessionService->createLoginToken($idUser, "terry123");
        // $userHasSessionModel = $userHasSessionService->findUserHasSessionModelByIdUser($idUser);

        // $array = $userHasSessionModel->getIdUserAndUsernameAndSessionAndExpiredAtAsArray();
        // $decryptedArray = Crypt::decrypt($encryptedArray);

        // var_dump($array);
        // var_dump($encryptedArray);
        // var_dump($decryptedArray);

        self::assertNotNull($idUser);
        // self::assertNotNull($userHasSessionModel);
        self::assertIsInt($idUser);
        // self::assertIsString($encryptedArray);
        // self::assertEquals($array, $decryptedArray);
    }
}
