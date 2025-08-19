<?php

namespace Tests\Feature\Domains\User;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Log;

use App\Domains\User\Model\SiprPhoneNumber;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class PhoneNumberControllerTest extends TestCase
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

    public function test_it_should_be_success_show_add_phone_number_view(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->get(route('add-phone-number'));

        $response->assertSeeText('Nomor');
        $response->assertSeeText("Tambah");
        $response->assertSeeText("Telpon");
        $response->assertSeeText("current");
    }

    public function test_it_should_be_success_add_phone_number(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $phone_number = "+62-812-3456-78901";

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(
                // '/dashboard/account/phone-numbroute('registration')',
                route('add-phone-number'),
                ["new-phone-number" => $phone_number]
            );

        $phone_number_record_model = SiprPhoneNumber::where(SiprPhoneNumber::PHONE_NUMBER, '=', $phone_number)
            ->first();

        assertNotNull($phone_number_record_model);
        assertEquals($phone_number_record_model->phone_number, $phone_number);
        $response->assertRedirect();
    }

    public function test_it_should_be_failed_add_phone_number_caused_by_unauthorized(): void
    {
        $phone_number = "+62-812-3456-7890";
        $response = $this->post(
            '/dashboard/account/phone-number/add',
            ["new-phone-number" => $phone_number]
        );

        $response->assertRedirect();
    }

    public function test_it_should_be_failed_add_phone_number_caused_by_field_null(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $phone_number = "";

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(
                route('add-phone-number'),
                ["new-phone-number" => $phone_number]
            );

        $response->assertUnprocessable();
    }

    public function test_it_should_be_failed_add_phone_number_caused_by_field_format_invalid(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $phone_number = "62-8";

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this
            ->withCookie(config('session.cookie'), $cookie)
            ->post(
                route('add-phone-number'),
                ["new-phone-number" => $phone_number]
            );

        $response->assertUnprocessable();
    }

    public function test_it_should_be_failed_add_phone_number_caused_by_field_too_long(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $phone_number = "+62-812-3456-7890-1234";

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $response = $this
            ->withCookie(config('session.cookie'), $cookie)
            ->post(
                route('add-phone-number'),
                ["new-phone-number" => $phone_number]
            );

        $response->assertUnprocessable();
    }
}
