<?php

namespace Tests\Feature\Domains\Schedule;

use Tests\TestCase;

use App\Domains\Room\Model\SiprRoomSession;

use App\Traits\Logs\CustomLogger;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class RoomSessionControllerTest extends TestCase
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
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->get(route('list-of-room-session'));

        $response->assertSeeText("aftar");
        $response->assertSeeText('esi');
        $response->assertSeeText("uangan");
        $response->assertSeeText("injam");
    }

    public function test_it_should_be_success_show_add_room_session_view(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->get(route('add-room-session'));

        $response->assertSeeText("Tambah");
        $response->assertSeeText('esi');
        $response->assertSeeText("injam");
        $response->assertSeeText("aru");
    }

    public function test_it_should_be_success_show_edit_room_session_view(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $data = [
            SiprRoomSession::SESSION_START => "07:00:00",
            SiprRoomSession::SESSION_END => "07:29:59",
        ];

        $record = SiprRoomSession::create($data);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->get(route('edit-room-session', $record));

        $response->assertSeeText("Edit");
        $response->assertSeeText('esi');
        $response->assertSeeText("uangan");
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
            "room-session-start" => "07:00:00",
            "room-session-end" => "07:39:59",
        ];

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('add-room-session'), $data);

        $response->assertRedirect();

        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_START, '=', $data["room-session-start"])
            ->first();

        assertNotNull($record);
    }

    public function test_it_should_be_failed_add_room_session_caused_by_already_exist_session_start(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            "room-session-start" => "07:00:00",
            "room-session-end" => "07:39:59",
        ];

        $record = SiprRoomSession::create([
            SiprRoomSession::SESSION_START => $data["room-session-start"],
            SiprRoomSession::SESSION_END => $data["room-session-end"],
        ]);

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('add-room-session'), $data);

        $response->assertRedirect();

        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_START, '=', $data["room-session-start"])
            ->first();

        assertNotNull($record);
    }

    public function test_it_should_be_failed_add_room_session_caused_by_already_exist_session_ends(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            "room-session-start" => "07:00:00",
            "room-session-end" => "07:39:59",
        ];

        $record = SiprRoomSession::create([
            SiprRoomSession::SESSION_START => $data["room-session-start"],
            SiprRoomSession::SESSION_END => $data["room-session-end"],
        ]);

        $data = [
            "room-session-start" => "07:10:00",
            "room-session-end" => "07:39:59",
        ];

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('add-room-session'), $data);

        $response->assertRedirect();

        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_END, '=', $data["room-session-end"])
            ->first();
        assertNotNull($record);

        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_END, '=', $data["room-session-start"])
            ->first();
        assertNull($record);
    }

    public function test_it_should_be_failed_add_room_session_caused_by_session_start_has_the_same_value_of_session_ends(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            "room-session-start" => "07:00:00",
            "room-session-end" => "07:00:00",
        ];

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('add-room-session'), $data);

        $response->assertRedirect();

        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_END, '=', $data["room-session-end"])
            ->first();

        assertNull($record);
    }

    public function test_it_should_be_failed_add_room_session_caused_by_session_start_has_value_ahead_of_session_ends(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            "room-session-start" => "07:40:00",
            "room-session-end" => "07:00:00",
        ];

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('add-room-session'), $data);

        $response->assertRedirect();

        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_END, '=', $data["room-session-end"])
            ->first();

        assertNull($record);
    }

    public function test_it_should_be_success_edit_room_session_only_session_end(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            SiprRoomSession::SESSION_START => "07:00:00",
            SiprRoomSession::SESSION_END => "07:29:59",
        ];
        $record = SiprRoomSession::create($data);

        $data = [
            "updated-room-session-start" => "07:00:00",
            "updated-room-session-end" => "07:39:59",
        ];
        $response_edit = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('edit-room-session', $record), $data);

        $response_edit->assertRedirect();
        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_END, '=', $data["updated-room-session-end"])
            ->first();
        assertNotNull($record);
    }

    public function test_it_should_be_success_edit_room_session_only_session_start(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            SiprRoomSession::SESSION_START => "07:10:00",
            SiprRoomSession::SESSION_END => "07:39:59",
        ];
        $record = SiprRoomSession::create($data);

        $data_updated = [
            "updated-room-session-start" => "07:00:00",
            "updated-room-session-end" => "07:39:59",
        ];
        $response_edit = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('edit-room-session', $record), $data_updated);

        $response_edit->assertRedirect();
        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_END, '=', $data_updated["updated-room-session-end"])
            ->first();

        assertNotNull($record);
        assertEquals($data_updated["updated-room-session-start"], $record->getRoomSessionStart());
        assertEquals($data[SiprRoomSession::SESSION_END], $record->getRoomSessionEnd());
    }

    public function test_it_should_be_success_edit_room_session_both_session_start_and_session_end(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            SiprRoomSession::SESSION_START => "07:00:00",
            SiprRoomSession::SESSION_END => "07:39:59",
        ];
        $record = SiprRoomSession::create($data);

        $data = [
            "updated-room-session-start" => "07:40:00",
            "updated-room-session-end" => "08:29:59",
        ];
        $response_edit = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('edit-room-session', $record), $data);

        $response_edit->assertRedirect();
        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_START, '=', $data["updated-room-session-start"])
            ->where(SiprRoomSession::SESSION_END, '=', $data["updated-room-session-end"])
            ->first();
        assertNotNull($record);
        assertEquals($data["updated-room-session-start"], $record->getRoomSessionStart());
        assertEquals($data["updated-room-session-end"], $record->getRoomSessionEnd());
    }

    public function test_it_should_be_failed_edit_room_session_caused_by_input_null(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            SiprRoomSession::SESSION_START => "07:00:00",
            SiprRoomSession::SESSION_END => "07:39:59",
        ];
        $record_insert = SiprRoomSession::create($data);
        assertNotNull($record_insert);

        $data_failed = [
            "updated-room-session-start" => "",
            "updated-room-session-end" => "",
        ];
        $response_edit = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('edit-room-session', $record_insert), $data_failed);

        $response_edit->assertRedirect();

        $record_query = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_START, '=', $data[SiprRoomSession::SESSION_START])
            ->where(SiprRoomSession::SESSION_END, '=', $data[SiprRoomSession::SESSION_END])
            ->first();
        assertNotNull($record_query);
        assertEquals($data[SiprRoomSession::SESSION_START], $record_query->getRoomSessionStart());
        assertEquals($data[SiprRoomSession::SESSION_END], $record_query->getRoomSessionEnd());
    }

    public function test_it_should_be_failed_edit_room_session_caused_by_session_start_is_ahead_of_session_finish(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            SiprRoomSession::SESSION_START => "07:00:00",
            SiprRoomSession::SESSION_END => "07:39:59",
        ];
        $record_insert = SiprRoomSession::create($data);
        assertNotNull($record_insert);

        $data_failed = [
            "updated-room-session-start" => "07:40:00",
            "updated-room-session-end" => "",
        ];
        $response_edit = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('edit-room-session', $record_insert), $data_failed);
        $response_edit->assertRedirect();

        $record_query = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_START, '=', $data[SiprRoomSession::SESSION_START])
            ->where(SiprRoomSession::SESSION_END, '=', $data[SiprRoomSession::SESSION_END])
            ->first();
        assertNotNull($record_query);
        assertEquals($data[SiprRoomSession::SESSION_START], $record_query->getRoomSessionStart());
        assertEquals($data[SiprRoomSession::SESSION_END], $record_query->getRoomSessionEnd());
    }

    public function test_it_should_be_failed_edit_room_session_caused_by_session_was_the_same_as_before(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            SiprRoomSession::SESSION_START => "07:00:00",
            SiprRoomSession::SESSION_END => "07:39:59",
        ];
        $record_insert = SiprRoomSession::create($data);
        assertNotNull($record_insert);

        $data_failed = [
            "updated-room-session-start" => "07:00:00",
            "updated-room-session-end" => "07:39:59",
        ];
        $response_edit = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('edit-room-session', $record_insert), $data_failed);
        $response_edit->assertRedirect();

        $record_query = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_START, '=', $data[SiprRoomSession::SESSION_START])
            ->where(SiprRoomSession::SESSION_END, '=', $data[SiprRoomSession::SESSION_END])
            ->first();
        assertNotNull($record_query);
        assertEquals($data[SiprRoomSession::SESSION_START], $record_query->getRoomSessionStart());
        assertEquals($data[SiprRoomSession::SESSION_END], $record_query->getRoomSessionEnd());
    }

    public function test_it_should_be_success_delete_room_session(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $data = [
            SiprRoomSession::SESSION_START => "07:00:00",
            SiprRoomSession::SESSION_END => "07:39:59",
        ];
        $record = SiprRoomSession::create($data);

        $response_edit = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('delete-room-session', $record));

        $response_edit->assertRedirect();
        $record = SiprRoomSession::select()
            ->where(SiprRoomSession::SESSION_START, '=', $data[SiprRoomSession::SESSION_START])
            ->where(SiprRoomSession::SESSION_END, '=', $data[SiprRoomSession::SESSION_END])
            ->first();
        assertNull($record);
    }
}
