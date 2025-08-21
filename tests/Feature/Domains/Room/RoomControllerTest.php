<?php

namespace Tests\Feature\Domains\Room;

use Tests\TestCase;

use App\Domains\Room\Model\SiprRoom;
use App\Traits\Logs\CustomLogger;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class RoomControllerTest extends TestCase
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

    public function test_it_should_be_success_show_list_room_session_view(): void
    {
        $response = $this->post(route('login'), [
            "username" => "superadmin",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->get(route('list-of-room'));

        $response->assertSeeText("aftar");
        $response->assertSeeText("uangan");
    }

    public function test_it_should_be_success_show_add_room_view(): void
    {
        $response = $this->post(route('login'), [
            "username" => "superadmin",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->get(route('add-room'));

        $response->assertSeeText("ambah");
        $response->assertSeeText("uangan");
        $response->assertSeeText("ama");
        $response->assertSeeText("ode");
    }

    public function test_it_should_be_success_add_room_session(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            'nama-ruangan' => 'Ruang Biasa',
            'kode-ruangan' => "B-352",
            'luas-ruangan' => '10.5',
            'tinggi-ruangan' => '2.5',
        ];

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('add-room'), $data);

        $response->assertRedirect();

        $record = SiprRoom::select()
            ->where(SiprRoom::CODE, '=', $data["kode-ruangan"])
            ->first();

        assertNotNull($record);
        assertEquals($data["nama-ruangan"], $record[SiprRoom::NAME]);
        assertEquals($data["kode-ruangan"], $record[SiprRoom::CODE]);
        assertEquals($data["luas-ruangan"], $record[SiprRoom::FLOOR_WIDE]);
        assertEquals($data["tinggi-ruangan"], $record[SiprRoom::HEIGHT]);
    }
}
