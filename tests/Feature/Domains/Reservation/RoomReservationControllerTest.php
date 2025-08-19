<?php

namespace Tests\Feature\Domains\Reservation;

use Tests\TestCase;

use App\Domains\Room\Model\SiprRoom;
use App\Traits\Logs\CustomLogger;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class RoomReservationControllerTest extends TestCase
{
    use CustomLogger;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->setUpTheTestEnvironment();
        parent::setUp();
    }

    public function test_it_should_be_success_show_list_all_room_reservation_request(): void
    {
        $response = $this->post(route('login'), [
            "username" => "superadmin",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->get(route('list-of-room-reservation-request'));

        $response->assertSeeText("aftar");
        $response->assertSeeText("uangan");
    }
}
