<?php

namespace Tests\Feature\Domains\User;

use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprUserHasSecondaryEmail;
use App\Domains\User\Model\SiprUser;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class EmailControllerTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpTheTestEnvironment();
    }

    public function test_it_should_be_success_show_add_email_view(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('add-email'));

        $response->assertSeeText("Tambah");
        $response->assertSeeText('Email');
        $response->assertSeeText("Back");
        $response->assertSeeText("current");
    }

    public function test_it_should_be_success_add_email(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $email = "sample.email@localhost.com";

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(
                route('add-email'),
                ["new-email" => $email]
            );

        $email_record_model = SiprSecondaryEmail::where(SiprSecondaryEmail::EMAIL, '=', $email)
            ->first();

        $response->assertRedirect();
        assertNotNull($email_record_model);
        assertEquals($email_record_model->email, $email);
    }

    public function test_it_should_be_failed_add_email_caused_by_unauthorized(): void
    {
        $email = "sample.email@localhost.com";

        $response = $this->post(
            route('add-email'),
            ["new-email" => $email]
        );

        $response->assertRedirect();
        $response->assertSeeText('ogin');
    }

    public function test_it_should_be_failed_add_email_caused_by_field_null(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $email = "";

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(
                route('add-phone-number'),
                ["new-email" => $email]
            );

        $response->assertUnprocessable();
        $response->assertSeeText('tidak');
        $response->assertSeeText('boleh');
        $response->assertSeeText('kosong');
    }

    public function test_it_should_be_failed_add_email_caused_by_field_format_invalid(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $email = "aokwokakokwo";

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(
                route('add-phone-number'),
                ["new-email" => $email]
            );

        $response->assertUnprocessable();
    }

    public function test_it_should_be_failed_add_email_caused_by_field_too_long(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $email =
            "sample.sample.sample.sample.sample.sample.sample." .
            "sample.sample.sample.sample.sample.sample.sample." .
            "sample.sample.sample.sample.sample.sample.sample." .
            "sample.sample.sample.sample.sample.sample.sample." .
            "sample.sample.sample.sample.sample.sample.sample." .
            "sample.sample.sample.sample.sample.sample.sample." .
            "sample.sample.sample.sample.sample.sample.sample." .
            "sample.sample.sample.sample@localhost.com";

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(
                route('add-email'),
                ["new-email" => $email]
            );

        $response->assertUnprocessable();
        $response->assertSeeText('tidak');
        $response->assertSeeText('bisa');
        $response->assertSeeText('lebih');
        $response->assertSeeText('255');
    }

    public function test_it_should_be_success_delete_email(): void
    {
        $username = "terryandrewdavis"; {

            $response_login = $this->post(route('login'), [
                "username" => $username,
                "password" => "Rahasia@1234",
            ]);

            $email = "sample.email@localhost.com";

            $cookie = $response_login
                ->getCookie(config('session.cookie'), false)
                ->getValue();

            $response_create_email = $this
                ->withCookie(config('session.cookie'), $cookie)
                ->post(
                    route('add-email'),
                    ["new-email" => $email]
                );

            $email_record_model = SiprSecondaryEmail::select()
                ->where(SiprSecondaryEmail::EMAIL, '=', $email)
                ->with('ownedByUsers')
                ->first();

            $response_create_email->assertRedirect();
            assertNotNull($email_record_model);
            assertEquals($email_record_model->email, $email);
            assertEquals($email_record_model->ownedByUsers()->first()->getUsername(), $username);
        }

        $response_delete_email = $this
            ->withCookie(config('session.cookie'), $cookie)
            ->post(
                '/dashboard/account/email/delete',
                ["old-email" => $email]
            );

        $email_record_model = SiprSecondaryEmail::select()
            ->where(SiprSecondaryEmail::EMAIL, '=', $email)
            ->with('ownedByUsers')
            ->first();

        $response_delete_email->assertRedirect();
        assertNull($email_record_model);
    }

    public function test_it_should_be_failed_delete_email_caused_by_forbidden_deleting_email_owned_by_others(): void
    {
        $email_david = null;

        $username = "davidheinemeierhansson"; {
            $david_user_record_model = SiprUser::createOrFirst([
                "id" => 3,
                "username" => $username,
                "name" => "Terry Andrew Davis",
                "password" => \Illuminate\Support\Facades\Hash::make('Rahasia@1234'),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

            $email_david = "sample.email.david@localhost.com";

            $email_david_model = SiprSecondaryEmail::create([
                "email" => $email_david,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

            SiprUserHasSecondaryEmail::create([
                "user_id" => 3,
                "email_id" => $email_david_model->getId(),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

            assertNotNull($david_user_record_model);
            assertNotNull($email_david_model);
        }

        $username_terry = "terryandrewdavis";
        $response_login_terry = $this->post(route('login'), [
            "username" => $username_terry,
            "password" => "Rahasia@1234",
        ]);

        $response_login_terry->assertRedirect();
        $cookie_terry = $response_login_terry
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response_delete_email = $this
            ->withCookie(config('session.cookie'), $cookie_terry)
            ->post(
                route('delete-email'),
                ["old-email" => $email_david]
            );

        $email_david_record_model = SiprSecondaryEmail::select()
            ->where(SiprSecondaryEmail::EMAIL, '=', $email_david)
            ->first();

        assertNotNull($email_david_record_model);
        $response_delete_email->assertForbidden();
    }

    public function test_it_should_be_failed_delete_email_caused_by_email_not_found(): void
    {
        $username = "terryandrewdavis";

        $response_login = $this->post(route('login'), [
            "username" => $username,
            "password" => "Rahasia@1234",
        ]);

        $email = "sample.email.1@localhost.com";

        $cookie = $response_login
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response_delete_email = $this
            ->withCookie(config('session.cookie'), $cookie)
            ->post(
                route('delete-email'),
                ["old-email" => $email]
            );

        $response_delete_email->assertUnprocessable();
        $response_delete_email->assertSeeText("email");
        $response_delete_email->assertSeeText("tidak");
        $response_delete_email->assertSeeText("ada");
    }
}
