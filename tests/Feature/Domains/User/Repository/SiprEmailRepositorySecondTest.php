<?php

namespace Tests\Feature\Domains\User\Repository;

use App\Domains\User\Model\SiprEmail;
use App\Domains\User\Repository\Contracts\SiprEmailRepository;
use App\Domains\User\Service\Contracts\SiprEmailService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprEmailRepositorySecondTest extends TestCase
{
    private $tableName = "sipr_emails";

    private SiprEmailRepository $repository;

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->repository = $this->app->make(SiprEmailRepository::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailRepositorySecondTest::testCreateEmailSuccessScenario" tests/Feature/
     */
    public function testCreateEmailSuccessScenario(): void
    {
        $idEmail = $this
            ->repository
            ->createEmail("test@localhost.com");

        self::assertNotNull($idEmail);
        self::assertIsInt($idEmail);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailRepositorySecondTest::testGetIdEmailByEmail" tests/Feature/
     */
    public function testGetIdEmailByEmail(): void
    {
        $service = $this->repository;

        $idEmail = $service
            ->createEmail("test@localhost.com");

        $email = $service->findEmailById($idEmail);

        self::assertNotNull($email);
        self::assertInstanceOf(SiprEmail::class, $email);
        self::assertSame($idEmail, $email->id);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailRepositorySecondTest::testFindEmailById" tests/Feature/
     */
    public function testFindEmailById(): void
    {
        $service = $this->repository;

        $idEmail = $service
            ->createEmail("test@localhost.com");

        $email = $service->findEmailById($idEmail);

        self::assertNotNull($email);
        self::assertInstanceOf(SiprEmail::class, $email);
        self::assertSame($idEmail, $email->id);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailRepositorySecondTest::testUpdateEmailById" tests/Feature/
     */
    public function testUpdateEmailById(): void
    {
        $service = $this->repository;

        $idEmail = $service
            ->createEmail("test@localhost.com");

        $email = $service
            ->findEmailById($idEmail);

        $service
            ->updateEmailById($idEmail, "testUpdate@localhost.com");

        $updatedEmail = $service
            ->findEmailById($idEmail);

        self::assertNotNull($email);
        self::assertNotNull($updatedEmail);
        self::assertInstanceOf(SiprEmail::class, $email);
        self::assertInstanceOf(SiprEmail::class, $updatedEmail);
        self::assertSame($idEmail, $email->id);
        self::assertSame($idEmail, $updatedEmail->id);
        self::assertNotSame($email->email, $updatedEmail->email);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailRepositorySecondTest::testDeleteEmailById" tests/Feature/
     */
    public function testDeleteEmailById(): void
    {
        $service = $this->repository;

        $idEmail = $service->createEmail("test@localhost.com");
        $email = $service->findEmailById($idEmail);
        $service->deleteEmailById($idEmail);
        
        self::assertNotNull($email);
        
        // Statement ini harus diatas kode yang akan throw exception.
        self::expectException(ModelNotFoundException::class);
        $service->findEmailById($idEmail);
    }
}
