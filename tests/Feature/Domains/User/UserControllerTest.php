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

// use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Http\Middleware\Custom\Authentication\EnsureUserIsLogin;
use Illuminate\Support\Carbon;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class UserControllerTest extends TestCase
{
    // use RefreshDatabase;

    private SiprUser $user;

    protected function setUp(): void
    {
        parent::setUp();

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

        /*
        |
        */
        DB::delete("DELETE FROM {$room_session_reservation_requests_table_name}");
        DB::delete("DELETE FROM {$room_reservation_requests_table_name}");
        DB::delete("DELETE FROM {$user_has_role_table_name}");
        DB::delete("DELETE FROM {$user_has_phone_number_table_name}");
        DB::delete("DELETE FROM {$user_has_email_table_name}");
        DB::delete("DELETE FROM {$phone_number_table_name}");
        DB::delete("DELETE FROM {$email_table_name}");
        DB::delete("DELETE FROM {$role_table_name}");
        DB::delete("DELETE FROM {$user_table_name}");
        DB::delete("DELETE FROM {$session_table_name} WHERE `user_agent` = 'Symfony'");

        DB::statement("ALTER TABLE {$room_session_reservation_requests_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$room_reservation_requests_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_phone_number_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_email_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_role_table_name} AUTO_INCREMENT = 1");
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
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }

        if ($user_model !== null) {
            # code...
            $this->user = $user_model;
        }

        DB::commit();
    }

    public function test_it_should_be_success_register_as_new_user(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertRedirect();

        $davis_hansson = SiprUser::where(SiprUser::COLUMN_USERNAME_ITS_NAME, '=', $username)
            ->with('hasRoles')
            ->first();

        assertNotNull($davis_hansson);
        assertNotNull($davis_hansson->hasRoles()->first()->role);

        assertEquals($davis_hansson->hasRoles()->first()->role, SiprRole::GUEST_ROLE);
        assertEquals($username, $davis_hansson->getUsername());
    }

    public function test_it_should_be_failed_register_caused_by_not_check_the_agreed_terms_of_use(): void
    {
        $username = "davidhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
        ]);

        $response->assertSeeText("Harus");
        $response->assertSeeText("mengisi");
        $response->assertSeeText("persetujuan");
        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_username_duplicate(): void
    {
        $username = "terryandrewdavis";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_username_is_null(): void
    {
        $username = "";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_username_is_not_8_characters_length(): void
    {
        $username = "terry";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_username_is_not_lowercase(): void
    {
        $username = "Terryandrewdavis";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_name_is_null(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_name_is_not_8_characters_length(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_password_is_null(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => '',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_password_is_not_contains_uppercase(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_password_is_not_contains_numbers(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@AAA',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_password_is_not_contains_symbols(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'RahasiaAAA12',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_password_is_not_contains_lowercase(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'RAHASIA@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_password_is_not_8_characters_length(): void
    {
        $username = "davidheinemeierhansson";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Ra@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_success_add_phone_number(): void
    {
        $response = $this->post('/login', [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(
                '/dashboard/account/phone-number/add',
                ["new-phone-number" => ""]
            );

        $response->assertBadRequest();
    }
}
