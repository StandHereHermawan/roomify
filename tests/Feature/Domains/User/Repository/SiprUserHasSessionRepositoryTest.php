<?php

namespace Tests\Feature\Domains\User\Service;

use App\Domains\User\Repository\Contracts\SiprUserHasSessionRepository;
use App\Domains\User\Service\Contracts\SiprUserService;

use Crypt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use function GuzzleHttp\json_encode;

class SiprUserHasSessionRepositoryTest extends TestCase
{
    private $tableUser = "sipr_users";
    private $tableUserHasSession = "sipr_user_has_sessions";
    private SiprUserService $siprUserService;
    private SiprUserHasSessionRepository $siprUserHasSessionRepo;

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
        $this->siprUserHasSessionRepo = $this->app->make(SiprUserHasSessionRepository::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasSessionRepositoryTest::testCreateUserHasSession" tests/Feature/
     */
    public function testCreateUserHasSession(): void
    {
        $userService = $this->siprUserService;
        $userHasSessionService = $this->siprUserHasSessionRepo;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");

        $user = $userService->findUserById($idUser);
        $username = $user->getUsername();
        
        $name = $user->getName();

        $json1 = json_encode(["idUser" => $idUser, "username" => $username, "name" => $name]);
        $json2 = json_encode(["idUser" => $idUser, "username" => $username]);
        $json3 = json_encode(["idUser" => $idUser, "username" => $username]);
        
        $session1 = hash('sha256', $json1);
        $session2 = hash('sha256', $json1);
        $session3 = hash('sha256', $json2);
        $session4 = hash('sha256', $json3);

        $session = $session1;

        // var_dump($session1);
        // var_dump($session2);
        // var_dump($session3);
        // var_dump($session4);

        $idSession = $userHasSessionService->createUserHasSession($idUser, "terry123", $session);

        self::assertNotNull($idUser);
        self::assertNotNull($idSession);
        self::assertIsInt($idSession);
        self::assertIsInt($idUser);
        self::assertEquals($session3,$session4);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserHasSessionRepositoryTest::testCarbonToLongMillis" tests/Feature/
     */
    public function testCarbonToLongMillis(): void
    {
        $userService = $this->siprUserService;
        $userHasSessionService = $this->siprUserHasSessionRepo;

        $idUser = $userService->createUser("terry123", "Terry Davis", "Rahasia");

        $user = $userService->findUserById($idUser);
        $username = $user->getUsername();
        
        $name = $user->getName();

        $json1 = json_encode(["idUser" => $idUser, "username" => $username, "name" => $name]);
        $json2 = json_encode(["idUser" => $idUser, "username" => $username]);
        $json3 = json_encode(["idUser" => $idUser, "username" => $username]);
        
        $session1 = hash('sha256', $json1);
        $session2 = hash('sha256', $json1);
        $session3 = hash('sha256', $json2);
        $session4 = hash('sha256', $json3);

        $session = $session1;

        // var_dump($session1);
        // var_dump($session2);
        // var_dump($session3);
        // var_dump($session4);

        $idSession = $userHasSessionService->createUserHasSession($idUser, "terry123", $session);

        $userHasSessionModel = $userHasSessionService->findUserHasSessionModelByIdUser($idUser);
        $expiredAt = $userHasSessionModel->getExpiredAt();
        $expiredAtMillis = $userHasSessionModel->getExpiredAtMillis();
        $durationLeft = $userHasSessionModel->getDurationLeftSessionExpired();

        $carbonTime = Carbon::createFromTimeString($expiredAt);
        $millis = $carbonTime->valueOf();

        // var_dump($expiredAt);
        // var_dump($carbonTime);
        // var_dump($millis);
        // var_dump($expiredAtMillis);
        // var_dump($durationLeft);

        self::assertNotNull($idUser);
        self::assertNotNull($idSession);
        self::assertIsInt($idSession);
        self::assertIsInt($idUser);
        self::assertEquals($session3,$session4);
    }
}
