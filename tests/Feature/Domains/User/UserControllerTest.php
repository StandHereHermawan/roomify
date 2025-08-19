<?php

namespace Tests\Feature\Domains\User;

use Tests\TestCase;

use App\Domains\User\Model\SiprRole;

use App\Domains\User\Model\SiprUser;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Carbon;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class UserControllerTest extends TestCase
{
    // use RefreshDatabase;

    private SiprUser $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user =
            SiprUser::select()
                ->where(SiprUser::ID, '=', 2)
                ->first()
            ??
            SiprUser::createOrFirst(
                [
                    SiprUser::ID => 2,
                    SiprUser::USERNAME => "terryandrewdavis",
                    SiprUser::NAME => "Terry Andrew Davis",
                    SiprUser::PASSWORD => \Illuminate\Support\Facades\Hash::make('Rahasia@1234'),
                    SiprUser::CREATED_AT => Carbon::now(),
                    SiprUser::UPDATED_AT => Carbon::now(),
                ]
            );
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

        $davis_hansson = SiprUser::where(SiprUser::USERNAME, '=', $username)
            ->with('hasRoles')
            ->first();

        assertNotNull($davis_hansson);
        assertNotNull($davis_hansson->hasRoles()->first()->role);

        assertEquals($davis_hansson->hasRoles()->first()->role, SiprRole::GUEST);
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

        $response = $this->post(route('registration'), [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertSeeText("Username");
        $response->assertSeeText("already");
        $response->assertSeeText("taken");
        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_already_login(): void
    {
        $response = $this->post(route('login'), [
            "username" => "terryandrewdavis",
            "password" => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $username = "davidheinemeierhansson";

        $response = $this
            ->withCookie(config('session.cookie'), $cookie)
            ->post(route('registration'), [
                "username" => $username,
                "name" => "David Heinemeier Hansson",
                "password" => 'Rahasia@1234',
                "agreedTermsOfUse" => "true"
            ]);

        $response->assertRedirect();
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

        $response->assertSeeText("username");
        $response->assertSeeText("required");
        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_username_is_below_8_characters_length(): void
    {
        $username = "terry";

        $response = $this->post('/registration', [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertSeeText("username");
        $response->assertSeeText("at");
        $response->assertSeeText("least");
        $response->assertSeeText("8");
        $response->assertUnprocessable(); // 422 Http Status Code
    }

    public function test_it_should_be_failed_register_caused_by_username_is_exceed_maximum_character_length(): void
    {
        $username =
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry";

        $response = $this->post(route('registration'), [
            "username" => $username,
            "name" => "David Heinemeier Hansson",
            "password" => 'Rahasia@1234',
            "agreedTermsOfUse" => "true"
        ]);

        $response->assertSeeText("username");
        $response->assertSeeText("not");
        $response->assertSeeText("greater");
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

        $response->assertSeeText("username");
        $response->assertSeeText("must");
        $response->assertSeeText("lowercase");
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

    public function test_it_should_be_failed_register_caused_by_name_is_below_8_characters_length(): void
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

    public function test_it_should_be_failed_register_caused_by_name_is_exceed_maximum_character_length(): void
    {
        $name =
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry" .
            "terryterryterryterryterryterryterryterry";

        $response = $this->post('/registration', [
            "username" => "terryandrewdavis",
            "name" => $name,
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
}
