<?php

namespace Tests;

use App\Domains\Room\Model\SiprRoom;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\Domains\Room\Model\SiprRoomSession;

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

use App\Traits\Logs\CustomLogger;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\assertNotNull;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user_model;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpTheTestEnvironment();

        $room_reservation_requests_table_name = SiprRoomReservationRequest::TABLE_NAME;
        $user_has_role_table_name = SiprUserHasRole::TABLE_NAME;
        $user_has_email_table_name = SiprUserHasSecondaryEmail::TABLE_NAME;
        $user_has_phone_number_table_name = SiprUserHasPhoneNumber::TABLE_NAME;
        $email_table_name = SiprSecondaryEmail::TABLE_NAME;
        $phone_number_table_name = SiprPhoneNumber::TABLE_NAME;
        $role_table_name = SiprRole::TABLE_NAME;
        $user_table_name = SiprUser::TABLE_NAME;
        $session_table_name = SiprSession::TABLE_NAME;

        /**
         *|
         *| clean the table first.
         */
        DB::delete("DELETE FROM " . SiprRoomSessionReservationRequest::TABLE_NAME);
        DB::delete("DELETE FROM {$room_reservation_requests_table_name}");
        DB::delete("DELETE FROM " . SiprRoomSession::TABLE_NAME);
        DB::delete("DELETE FROM " . SiprRoom::TABLE_NAME);
        DB::delete("DELETE FROM {$user_has_role_table_name}");
        DB::delete("DELETE FROM {$user_has_phone_number_table_name}");
        DB::delete("DELETE FROM {$user_has_email_table_name}");
        DB::delete("DELETE FROM {$phone_number_table_name}");
        DB::delete("DELETE FROM {$email_table_name}");
        DB::delete("DELETE FROM {$role_table_name}");
        DB::delete("DELETE FROM {$user_table_name}");
        DB::delete("DELETE FROM {$session_table_name} WHERE `user_agent` = 'Symfony'");

        /**
         *|
         *| make the auto_increment start from 1 again.
         */
        DB::statement("ALTER TABLE " . SiprRoomSessionReservationRequest::TABLE_NAME . " AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$room_reservation_requests_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE " . SiprRoomSession::TABLE_NAME . " AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE " . SiprRoom::TABLE_NAME . " AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_phone_number_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_email_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_has_role_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$phone_number_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$email_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$role_table_name} AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE {$user_table_name} AUTO_INCREMENT = 1");

        DB::transaction(function () {
            $super_admin_record = SiprUser::select()
                ->where(SiprUser::USERNAME, '=', "superadmin")
                ->first()
                ??
                SiprUser::create([
                    SiprUser::USERNAME => "superadmin",
                    SiprUser::NAME => "Super Admin",
                    SiprUser::PASSWORD => Hash::make("Rahasia@1234"),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);

            $super_admin_role_record =
                SiprRole::select()
                    ->where(SiprRole::ROLE, '=', SiprRole::SUPER_ADMIN)
                    ->first()
                ??
                SiprRole::create([
                    SiprRole::ROLE => SiprRole::SUPER_ADMIN,
                ]);

            $super_admin_role_super =
                SiprUserHasRole::select()
                    ->where(SiprUserHasRole::USER_ID, '=', $super_admin_record->getId())
                    ->where(SiprUserHasRole::ROLE_ID, '=', $super_admin_role_record->getId())
                    ->first() ??
                SiprUserHasRole::create([
                    SiprUserHasRole::USER_ID => $super_admin_record->getId(),
                    SiprUserHasRole::ROLE_ID => $super_admin_role_record->getId(),
                ]);

            $this->user_model =
                SiprUser::select()->where(SiprUser::ID, '=', 2)->first()
                ??
                SiprUser::createOrFirst([
                    SiprUser::ID => 2,
                    SiprUser::USERNAME => "terryandrewdavis",
                    SiprUser::NAME => "Terry Andrew Davis",
                    SiprUser::PASSWORD => Hash::make('Rahasia@1234'),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);

            $guest_role_record =
                SiprRole::select()
                    ->where(SiprRole::ROLE, '=', SiprRole::GUEST)
                    ->first()
                ??
                SiprRole::create([
                    SiprRole::ROLE => SiprRole::GUEST,
                ]);

            $terry_has_guest_role =
                SiprUserHasRole::select()
                    ->where(SiprUserHasRole::USER_ID, '=', $this->user_model->getId())
                    ->where(SiprUserHasRole::ROLE_ID, '=', $guest_role_record->getId())
                    ->first() ??
                SiprUserHasRole::create([
                    SiprUserHasRole::USER_ID => $this->user_model->getId(),
                    SiprUserHasRole::ROLE_ID => $guest_role_record->getId(),
                ]);

            assertNotNull($super_admin_role_super);
            assertNotNull($terry_has_guest_role);
        });
    }
}
