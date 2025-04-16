<?php

namespace Tests\Feature\Service;

use App\Domains\User\Model\SiprEmail;
use App\Domains\User\Service\Contracts\SiprEmailService;
use App\Domains\User\Service\Contracts\SiprUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SiprEmailServiceTest extends TestCase
{
    private $tableName = "sipr_emails";

    private SiprEmailService $siprUserService;

    /**
     * 
     * @before
     */
    protected function setUp(): void
    {
        parent::setUp();
        DB::statement("DELETE FROM {$this->tableName}");
        DB::statement("ALTER TABLE {$this->tableName} AUTO_INCREMENT = 1;");
        $this->siprUserService = $this->app->make(SiprEmailService::class);
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "SiprUserRepositoryTest::testCreateEmailSuccessScenario" tests/Feature/
     */
    public function testCreateEmailSuccessScenario(): void
    {
        $idUser = $this->siprUserService->createEmail("terry@localhost.com");
        self::assertNotNull($idUser);
        self::assertIsInt($idUser);
    }
}
