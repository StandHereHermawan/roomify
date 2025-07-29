<?php

namespace Tests\Feature\Domains\User;

use App\Domains\Schedule\Model\SiprRoomReservationRequest;
use App\Domains\Schedule\Model\SiprRoomSessionReservationRequest;
use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprRole;
use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUserHasPhoneNumber;
use App\Domains\User\Model\SiprUserHasRole;
use App\Domains\User\Model\SiprUserHasSecondaryEmail;
use App\Domains\User\Model\SiprUser;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class AuthControllerTest extends TestCase
{
    private SiprUser $user;

    protected function setUp(): void
    {
        parent::setUp();

        /*
        |
        |   Database cleaner
        |
        */
        $room_session_reservation_requests_table_name = SiprRoomSessionReservationRequest::TABLE_NAME;
        $room_reservation_requests_table_name = SiprRoomReservationRequest::TABLE_NAME;
        $user_has_role_table_name = SiprUserHasRole::TABLE_NAME;
        $user_has_email_table_name = SiprUserHasSecondaryEmail::TABLE_NAME;
        $user_has_phone_number_table_name = SiprUserHasPhoneNumber::TABLE_NAME;
        $email_table_name = SiprSecondaryEmail::TABLE_NAME;
        $phone_number_table_name = SiprPhoneNumber::TABLE_NAME;
        $role_table_name = SiprRole::TABLE_NAME;
        $user_table_name = SiprUser::TABLE_NAME;
        $session_table_name = SiprSession::TABLE_NAME;

        DB::delete("DELETE FROM {$room_session_reservation_requests_table_name}");
        DB::delete("DELETE FROM {$room_reservation_requests_table_name}");
        DB::delete("DELETE FROM {$user_has_role_table_name}");
        DB::delete("DELETE FROM {$user_has_phone_number_table_name}");
        DB::delete("DELETE FROM {$user_has_email_table_name}");
        DB::delete("DELETE FROM {$phone_number_table_name}");
        DB::delete("DELETE FROM {$email_table_name}");
        DB::delete("DELETE FROM {$role_table_name}");
        DB::delete("DELETE FROM {$session_table_name} WHERE `user_agent` = 'Symfony'");

        DB::statement("ALTER TABLE {$room_session_reservation_requests_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$room_reservation_requests_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_role_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_phone_number_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_email_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$phone_number_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$email_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$role_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_table_name} AUTO_INCREMENT = 1");

        DB::beginTransaction();

        $user_model = SiprUser::where(SiprUser::COLUMN_ID_ITS_NAME, '=', 2)->first();

        if ($user_model === null) {
            # code...
            $this->user = SiprUser::createOrFirst([
                "id" => 2,
                "username" => "terryandrewdavis",
                "name" => "Terry Andrew Davis",
                "password" => \Illuminate\Support\Facades\Hash::make('Rahasia@1234'),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);
        }

        if ($user_model !== null) {
            # code...
            $this->user = $user_model;
        }

        DB::commit();
    }

    public function test_it_should_be_success_login(): void
    {
        $response = $this->post('/login', [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $session_id = $response
            ->baseRequest
            ->session()
            ->getId();

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->with('ownedByUser')
            ->first();

        assertNotNull($session_model);
        assertNotNull($session_model->user_id);
        assertEquals($this->user->getId(), $session_model->user_id);
        assertEquals($this->user->getUsername(), $session_model->ownedByUser()->first()->getUsername());

        $response->assertRedirect();
    }

    public function test_it_should_be_failed_login_username_is_null(): void
    {
        $response = $this->post('/login', [
            "username" => "",
            "password" => "Rahasia@1234",
        ]);

        $response->assertBadRequest();
        $response->assertSeeText('sername');
        $response->assertSeeText('password');
        $response->assertSeeText('wrong');
    }

    public function test_it_should_be_failed_login_username_is_wrong(): void
    {
        $response = $this->post('/login', [
            "username" => "terryandrew",
            "password" => "Rahasia@1234",
        ]);

        $response->assertBadRequest();
        $response->assertSeeText('sername');
        $response->assertSeeText('password');
        $response->assertSeeText('wrong');
    }

    public function test_it_should_be_failed_login_password_is_wrong(): void
    {
        $response = $this->post('/login', [
            "username" => "terryandrew",
            "password" => "Rahasia@123",
        ]);

        $response->assertBadRequest();
        $response->assertSeeText('sername');
        $response->assertSeeText('password');
        $response->assertSeeText('wrong');
    }

    public function test_it_should_be_failed_login_password_is_null(): void
    {
        $response = $this->post('/login', [
            "username" => "terryandrew",
            "password" => "",
        ]);

        $response->assertBadRequest();
        $response->assertSeeText('sername');
        $response->assertSeeText('password');
        $response->assertSeeText('wrong');
    }
}
