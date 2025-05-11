<?php

namespace Tests\Feature\Domains\User\Repository;

use App\Domains\User\Model\SiprEmail;
use App\Domains\User\Repository\Contracts\SiprEmailRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiprEmailRepositoryTest extends TestCase
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
     * vendor/bin/phpunit --filter "SiprEmailServiceTest::testCreateEmailSuccessScenario" tests/Feature/
     */
    public function testCreateEmailSuccessScenario(): void
    {
        $idEmail = $this
            ->repository
            ->createEmailAndReturnItsId("test@localhost.com");

        self::assertNotNull($idEmail);
        self::assertIsInt($idEmail);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailServiceTest::testGetIdEmailByEmailSuccessScenario" tests/Feature/
     */
    public function testGetIdEmailByEmailSuccessScenario(): void
    {
        $service = $this->repository;

        $idEmail = $service
            ->createEmailAndReturnItsId("test@localhost.com");

        $email = $service->findEmailModelById($idEmail);

        self::assertNotNull($email);
        self::assertInstanceOf(SiprEmail::class, $email);
        self::assertSame($idEmail, $email->id);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailServiceTest::testFindEmailByIdSuccessScenario" tests/Feature/
     */
    public function testFindEmailByIdSuccessScenario(): void
    {
        $service = $this->repository;

        $idEmail = $service
            ->createEmailAndReturnItsId("test@localhost.com");

        $email = $service->findEmailModelById($idEmail);

        self::assertNotNull($email);
        self::assertInstanceOf(SiprEmail::class, $email);
        self::assertSame($idEmail, $email->id);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprEmailServiceTest::testUpdateEmailByIdSuccessScenario" tests/Feature/
     */
    public function testUpdateEmailByIdSuccessScenario(): void
    {
        $service = $this->repository;

        $idEmail = $service
            ->createEmailAndReturnItsId("test@localhost.com");

        $email = $service
            ->findEmailModelById($idEmail);

        $service
            ->updateEmailById($idEmail, "testUpdate@localhost.com");

        $updatedEmail = $service
            ->findEmailModelById($idEmail);

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
     * vendor/bin/phpunit --filter "SiprEmailServiceTest::testDeleteEmailByIdSuccessScenario" tests/Feature/
     */
    public function testDeleteEmailByIdSuccessScenario(): void
    {
        $service = $this->repository;

        $idEmail = $service->createEmailAndReturnItsId("test@localhost.com");
        $email = $service->findEmailModelById($idEmail);
        $service->deleteEmailById($idEmail);
        
        self::assertNotNull($email);
        
        // Statement ini harus diatas kode yang akan throw exception.
        self::expectException(ModelNotFoundException::class);
        $service->findEmailModelById($idEmail);
    }
}
