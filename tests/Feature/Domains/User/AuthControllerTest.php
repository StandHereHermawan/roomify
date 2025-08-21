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

use Illuminate\Support\Carbon;
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

        $this->user = SiprUser::select()
            ->where(SiprUser::ID, '=', 2)
            ->first()
            ??
            SiprUser::create(
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

    public function test_it_should_be_success_login(): void
    {
        $response = $this->post(route('login'), [
            SiprUser::USERNAME => "terryandrewdavis",
            SiprUser::PASSWORD => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $session_id = $response
            ->baseRequest
            ->session()
            ->getId();

        $session_model = SiprSession::select()
            ->where(SiprSession::ID, '=', $session_id)
            ->with('ownedByUser')
            ->first();

        $response->assertRedirect();
        assertNotNull($session_model);
        assertNotNull($cookie);
        assertNotNull($session_model->user_id);
        assertEquals($this->user->getId(), $session_model->user_id);
        assertEquals($this->user->getUsername(), $session_model->ownedByUser()->first()->getUsername());

    }

    public function test_it_should_be_failed_login_username_is_null(): void
    {
        $response = $this->post(route('login'), [
            SiprUser::USERNAME => "",
            SiprUser::PASSWORD => "Rahasia@1234",
        ]);

        $response->assertBadRequest();
        $response->assertSeeText('sername');
        $response->assertSeeText('password');
        $response->assertSeeText('wrong');
    }

    public function test_it_should_be_failed_login_username_is_wrong(): void
    {
        $response = $this->post(route('login'), [
            SiprUser::USERNAME => "terryandrew",
            SiprUser::PASSWORD => "Rahasia@1234",
        ]);

        $response->assertBadRequest();
        $response->assertSeeText('sername');
        $response->assertSeeText('password');
        $response->assertSeeText('wrong');
    }

    public function test_it_should_be_failed_login_password_is_wrong(): void
    {
        $response = $this->post(route('login'), [
            SiprUser::USERNAME => "terryandrew",
            SiprUser::PASSWORD => "Rahasia@123",
        ]);

        $response->assertBadRequest();
        $response->assertSeeText('sername');
        $response->assertSeeText('password');
        $response->assertSeeText('wrong');
    }

    public function test_it_should_be_failed_login_password_is_null(): void
    {
        $response = $this->post(route('login'), [
            SiprUser::USERNAME => "terryandrew",
            SiprUser::PASSWORD => "",
        ]);

        $response->assertBadRequest();
        $response->assertSeeText('sername');
        $response->assertSeeText('password');
        $response->assertSeeText('wrong');
    }

    public function test_it_should_be_success_logout(): void
    {
        $response = $this->post(route('login'), [
            SiprUser::USERNAME => "terryandrewdavis",
            SiprUser::PASSWORD => "Rahasia@1234",
        ]);

        $cookie = $response
            ->getCookie(config('session.cookie'), false)
            ->getValue();

        $logout_response = $this->withCookie(config('session.cookie'), $cookie)
            ->post(route('logout'));

        $response->assertRedirect();
        $logout_response->assertRedirect();
    }
}
