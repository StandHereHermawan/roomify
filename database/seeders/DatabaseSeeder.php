<?php

namespace Database\Seeders;

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;
use App\Domains\Schedule\Model\SiprRoomReservationRequest;
use App\Domains\Schedule\Model\SiprRoomSessionReservationRequest;
use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprUserHasPhoneNumber;
use App\Domains\User\Model\SiprRole;
use App\Domains\User\Model\SiprUserHasSecondaryEmail;
use App\Domains\User\Model\SiprUserHasRole;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    private $tableName = SiprUser::TABLE_NAME;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {

            $record_model_super_admin = null;
            $record_model_terry_davis = null;
            $record_model_david_hansson = null;

            /*
            |
            |
            |   User Seeder
            */ {
                $username = "superadmin";
                $record_model_super_admin =
                    SiprUser::select()
                        ->where(SiprUser::USERNAME, '=', $username)
                        ->first()
                    ??
                    SiprUser::create([
                        "username" => $username,
                        "name" => "Super Admin",
                        "password" => Hash::make('Rahasia@1234'),
                        "created_at" => \Illuminate\Support\Carbon::now(),
                        "updated_at" => \Illuminate\Support\Carbon::now(),
                    ]);

                $username = "terryandrewdavis";
                $record_model_terry_davis =
                    SiprUser::select()
                        ->where(SiprUser::USERNAME, '=', $username)
                        ->first()
                    ??
                    SiprUser::create([
                        "username" => $username,
                        "name" => "Terry Andrew Davis",
                        "password" => Hash::make('Rahasia@1234'),
                        "created_at" => \Illuminate\Support\Carbon::now(),
                        "updated_at" => \Illuminate\Support\Carbon::now(),
                    ]);

                $username = "davidheinemeierhansson";
                $record_model_david_hansson =
                    SiprUser::select()
                        ->where(SiprUser::USERNAME, '=', $username)
                        ->first()
                    ??
                    SiprUser::create([
                        "username" => $username,
                        "name" => "David Heinemeier Hansson",
                        "password" => Hash::make('Rahasia@1234'),
                        "created_at" => \Illuminate\Support\Carbon::now(),
                        "updated_at" => \Illuminate\Support\Carbon::now(),
                    ]);

                for ($iteration = 0; $iteration < 5; $iteration++) {
                    $userNumber = $iteration + 1;

                    $username = "username{$userNumber}";
                    $record_model_david_hansson = SiprUser::select()->where(SiprUser::USERNAME, '=', $username)->first();
                    $record_model_david_hansson = $record_model_david_hansson === null ? SiprUser::create([
                        "username" => $username,
                        "name" => "name{$userNumber}",
                        "password" => Hash::make('Rahasia@1234'),
                        "created_at" => \Illuminate\Support\Carbon::now(),
                        "updated_at" => \Illuminate\Support\Carbon::now(),
                    ]) : $record_model_david_hansson;
                }
            }


            /*
            |
            |
            |   email seeder and email relation with user table.
            */ {
                $email = "super.admin@localhost.com";
                $email_super_admin_record_model = SiprSecondaryEmail::select()->where(SiprSecondaryEmail::EMAIL, '=', $email)->first();
                $email_super_admin_record_model = $email_super_admin_record_model === null ? SiprSecondaryEmail::create([
                    "email" => $email,
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $email_super_admin_record_model;

                $email = "terry.davis@localhost.com";
                $email_terry_record_model = SiprSecondaryEmail::select()->where(SiprSecondaryEmail::EMAIL, '=', $email)->first();
                $email_terry_record_model = $email_terry_record_model === null ? SiprSecondaryEmail::create([
                    "email" => $email,
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $email_terry_record_model;

                $email = "david.hansson@localhost.com";
                $email_david_record_model = SiprSecondaryEmail::select()->where(SiprSecondaryEmail::EMAIL, '=', $email)->first();
                $email_david_record_model = $email_david_record_model === null ? SiprSecondaryEmail::create([
                    "email" => $email,
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $email_david_record_model;

                $terry_has_email = SiprUserHasSecondaryEmail::select()
                    ->where(SiprUserHasSecondaryEmail::COLUMN_USER_ID_ITS_NAME, '=', $record_model_terry_davis->getId())
                    ->where(SiprUserHasSecondaryEmail::COLUMN_EMAIL_ID_ITS_NAME, '=', $email_terry_record_model->getId())
                    ->first();
                $terry_has_email = $terry_has_email === null ? SiprUserHasSecondaryEmail::create([
                    "user_id" => $record_model_terry_davis->getId(),
                    "email_id" => $email_terry_record_model->getId(),
                ]) : $terry_has_email;

                $david_has_email = SiprUserHasSecondaryEmail::select()
                    ->where(SiprUserHasSecondaryEmail::COLUMN_USER_ID_ITS_NAME, '=', $record_model_david_hansson->getId())
                    ->where(SiprUserHasSecondaryEmail::COLUMN_EMAIL_ID_ITS_NAME, '=', $email_david_record_model->getId())
                    ->first();
                $david_has_email = $david_has_email === null ? SiprUserHasSecondaryEmail::create([
                    "user_id" => $record_model_david_hansson->getId(),
                    "email_id" => $email_david_record_model->getId(),
                ]) : $david_has_email;

                $super_admin_has_email = SiprUserHasSecondaryEmail::select()
                    ->where(SiprUserHasSecondaryEmail::COLUMN_USER_ID_ITS_NAME, '=', $record_model_david_hansson->getId())
                    ->where(SiprUserHasSecondaryEmail::COLUMN_EMAIL_ID_ITS_NAME, '=', $email_david_record_model->getId())
                    ->first();
                $super_admin_has_email = $super_admin_has_email === null ? SiprUserHasSecondaryEmail::create([
                    "user_id" => $record_model_david_hansson->getId(),
                    "email_id" => $email_david_record_model->getId(),
                ]) : $super_admin_has_email;
            }

            /*
            |
            |
            |   phone number seeder and phone number relation
            */ {
                $phone_number = "+62-8" . "12" . "-" . "3456" . "-" . "7890";
                $terry_phone_number_record = SiprPhoneNumber::select()->where(SiprPhoneNumber::PHONE_NUMBER, '=', $phone_number)->first();
                $terry_phone_number_record = $terry_phone_number_record === null ? SiprPhoneNumber::create([
                    "phone_number" => $phone_number,
                    "created_at" => \Illuminate\Support\Carbon::now()
                        ->addHours(7)
                ]) : $terry_phone_number_record;

                $phone_number = "+62-8" . random_int(10, 99) . "-" . random_int(1000, 9999) . "-" . random_int(1000, 9999);
                $super_admin_phone_number_record = SiprPhoneNumber::select()->where(SiprPhoneNumber::PHONE_NUMBER, '=', $phone_number)->first();
                $super_admin_phone_number_record = $super_admin_phone_number_record === null ? SiprPhoneNumber::create([
                    "phone_number" => $phone_number,
                    "created_at" => \Illuminate\Support\Carbon::now()
                        ->addHours(7)
                ]) : $super_admin_phone_number_record;

                $phone_number = "+62-8" . random_int(10, 99) . "-" . random_int(1000, 9999) . "-" . random_int(1000, 9999);
                $david_phone_number_record = SiprPhoneNumber::select()->where(SiprPhoneNumber::PHONE_NUMBER, '=', $phone_number)->first();
                $david_phone_number_record = $david_phone_number_record === null ? SiprPhoneNumber::create([
                    "phone_number" => $phone_number,
                    "created_at" => \Illuminate\Support\Carbon::now()
                        ->addHours(7)
                ]) : $david_phone_number_record;

                $terry_has_phone = SiprUserHasPhoneNumber::select()
                    ->where(SiprUserHasPhoneNumber::COLUMN_USER_ID_ITS_NAME, '=', $record_model_terry_davis->getId())
                    ->where(SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME, '=', $terry_phone_number_record->getId())
                    ->first();
                $terry_has_phone = $terry_has_phone === null ? SiprUserHasPhoneNumber::create([
                    "user_id" => $record_model_terry_davis->getId(),
                    "phone_number_id" => $terry_phone_number_record->getId(),
                ]) : $terry_has_phone;

                $david_hein_has_phone = SiprUserHasPhoneNumber::select()
                    ->where(SiprUserHasPhoneNumber::COLUMN_USER_ID_ITS_NAME, '=', $record_model_david_hansson->getId())
                    ->where(SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME, '=', $david_phone_number_record->getId())
                    ->first();
                $david_hein_has_phone = $david_hein_has_phone === null ? SiprUserHasPhoneNumber::create([
                    "user_id" => $record_model_david_hansson->getId(),
                    "phone_number_id" => $david_phone_number_record->getId(),
                ]) : $david_hein_has_phone;

                $super_admin_has_phone = SiprUserHasPhoneNumber::select()
                    ->where(SiprUserHasPhoneNumber::COLUMN_USER_ID_ITS_NAME, '=', $record_model_super_admin->getId())
                    ->where(SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME, '=', $super_admin_phone_number_record->getId())
                    ->first();
                $super_admin_has_phone = $super_admin_has_phone === null ? SiprUserHasPhoneNumber::create([
                    "user_id" => $record_model_super_admin->getId(),
                    "phone_number_id" => $super_admin_phone_number_record->getId(),
                ]) : $super_admin_has_phone;
            }

            /*
            |
            |
            |   role seeder and role relation
            */ {
                $role_name = "SUPER_ADMIN";
                $super_admin_role_record = SiprRole::where(SiprRole::ROLE, '=', $role_name)->first();
                $super_admin_role_record = $super_admin_role_record === null ? SiprRole::create([
                    "role" => $role_name,
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $super_admin_role_record;

                $role_name = "GUEST";
                $guest_role_record = SiprRole::where(SiprRole::ROLE, '=', $role_name)->first();
                $guest_role_record = $guest_role_record === null ? SiprRole::create([
                    "role" => $role_name,
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $guest_role_record;

                $role_name = "OPERATOR";
                $operator_role_record = SiprRole::where(SiprRole::ROLE, '=', $role_name)->first();
                $operator_role_record = $operator_role_record === null ? SiprRole::create([
                    "role" => $role_name,
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $operator_role_record;


                $super_admin_has_role = SiprUserHasRole::select()
                    ->where(SiprUserHasRole::COLUMN_USER_ID_ITS_NAME, '=', $record_model_super_admin->getId())
                    ->where(SiprUserHasRole::COLUMN_ROLE_ID_ITS_NAME, '=', $super_admin_role_record->getId())
                    ->first();
                $super_admin_has_role = $super_admin_has_role === null ? SiprUserHasRole::create([
                    "user_id" => $record_model_super_admin->getId(),
                    "role_id" => $super_admin_role_record->getId(),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $super_admin_has_role;

                $terry_andrew_davis_has_role = SiprUserHasRole::select()
                    ->where(SiprUserHasRole::COLUMN_USER_ID_ITS_NAME, '=', $record_model_terry_davis->getId())
                    ->where(SiprUserHasRole::COLUMN_ROLE_ID_ITS_NAME, '=', $guest_role_record->getId())
                    ->first();
                $terry_andrew_davis_has_role = $terry_andrew_davis_has_role === null ? SiprUserHasRole::create([
                    "user_id" => $record_model_terry_davis->getId(),
                    "role_id" => $guest_role_record->getId(),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $terry_andrew_davis_has_role;

                $david_hansson_has_role_model = SiprUserHasRole::select()
                    ->where(SiprUserHasRole::COLUMN_USER_ID_ITS_NAME, '=', $record_model_terry_davis->getId())
                    ->where(SiprUserHasRole::COLUMN_ROLE_ID_ITS_NAME, '=', $guest_role_record->getId())
                    ->first();
                $david_hansson_has_role_model = $david_hansson_has_role_model === null ? SiprUserHasRole::create([
                    "user_id" => $record_model_david_hansson->getId(),
                    "role_id" => $guest_role_record->getId(),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $david_hansson_has_role_model;
            }

            /*
            |
            |   room seeder.
            |
            */
            $room_model_collection = collect([]); {
                function random_double($min = 0, $max = 1): float
                {
                    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
                }

                for ($i = 0; $i < 50; $i++) {
                    $roomNumber = $i + 1;
                    $number = null;

                    if ($i < 9) {
                        $number = "B-30{$roomNumber}";
                    }

                    if ($i >= 9) {
                        $number = "B-3{$roomNumber}";
                    }

                    $room_model = SiprRoom::select()->where(SiprRoom::COLUMN_ROOM_CODE_ITS_NAME, '=', $number)->first();
                    $room_model = $room_model === null ? SiprRoom::create([
                        "room_code" => $number,
                        "name" => fake()->randomElement(['Ruang-Biasa', 'Lab']),
                        "meter_room_height" => random_double(2.5, 3.5),
                        "meter_squared_floor_wide" => random_double(7.5, 12.5),
                        "created_at" => \Illuminate\Support\Carbon::now(),
                        "updated_at" => \Illuminate\Support\Carbon::now(),
                    ]) : $room_model;

                    if (!$room_model_collection->search($room_model)) {
                        Log::debug('class: DatabaseSeeder | method: run | $room_model_collection added new data.');
                        $room_model_collection->push($room_model);
                    }
                }
            }

            /*
            |
            |
            |   room session seeder.
            */
            $room_session_model_collection = collect([]); {
                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(7)->minute(0)->second(0))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(7)->minute(0)->second(0),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(7)->minute(49)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(7)->minute(50)->second(0))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(7)->minute(50)->second(0),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(8)->minute(39)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(8)->minute(40)->second(0))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(8)->minute(40)->second(0),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(9)->minute(29)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(9)->minute(30)->second(00))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(9)->minute(30)->second(00),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(10)->minute(19)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(10)->minute(20)->second(00))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(10)->minute(20)->second(00),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(11)->minute(9)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(11)->minute(10)->second(00))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(11)->minute(10)->second(00),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(12)->minute(0)->second(00),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(12)->minute(50)->second(0))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(12)->minute(50)->second(0),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(13)->minute(39)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(13)->minute(40)->second(0))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(13)->minute(40)->second(0),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(14)->minute(29)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(14)->minute(30)->second(00))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(14)->minute(30)->second(00),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(15)->minute(19)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(15)->minute(20)->second(00))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(15)->minute(20)->second(00),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(16)->minute(9)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(16)->minute(10)->second(00))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(16)->minute(10)->second(00),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(16)->minute(59)->second(59),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

                $sipr_room_session = SiprRoomSession::select()
                    ->where(SiprRoomSession::SESSION_START, '=', \Illuminate\Support\Carbon::now()->hour(17)->minute(00)->second(00))
                    ->first();
                $sipr_room_session = $sipr_room_session === null ? SiprRoomSession::create([
                    "room_session_start" => \Illuminate\Support\Carbon::now()->hour(17)->minute(00)->second(00),
                    "room_session_end" => \Illuminate\Support\Carbon::now()->hour(17)->minute(50)->second(00),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]) : $sipr_room_session;

            }

            // $id_room_reservation = 1;
            // $days_added = 0;
            // $room_id = 1;
            // $user_id = 2;
            // $status = null;
            // $determined_at = null;
            // 
            // for ($iteration_room_reservation = 0; $iteration_room_reservation < 15; $iteration_room_reservation++) {
            // 
            // if ($iteration_room_reservation < 6) {
            // $status = "PENDING";
            // }
            // 
            // if ($iteration_room_reservation >= 6 && $iteration_room_reservation <= 10) {
            // $status = "ACCEPTED";
            // $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            // }
            // 
            // if ($iteration_room_reservation > 10) {
            // $status = "REJECTED";
            // $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            // }
            // 
            // $sipr_room_reservation =
            // SiprRoomReservationRequest::select()
            // ->where(SiprRoomReservationRequest::COLUMN_ID_ITS_NAME, '=', $id_room_reservation)
            // ->first()
            // ??
            // SiprRoomReservationRequest::create([
            // "{$column_table_room_reservation_ID_its_name}" => $id_room_reservation,
            // "{$column_table_room_reservation_USER_ID_its_name}" => $user_id,
            // "{$column_table_room_reservation_ROOM_ID_its_name}" => $room_id,
            // "{$column_table_room_reservation_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays($days_added),
            // "{$column_table_room_reservation_DETERMINED_AT_its_name}" => $determined_at,
            // "{$column_table_room_reservation_STATUS_its_name}" => $status,
            // "{$column_table_room_reservation_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_table_room_reservation_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // ]);
            // 
            // $id_room_session = 1;
            // for ($iteration_room_session_reservation = 0; $iteration_room_session_reservation < 3; $iteration_room_session_reservation++) {
            // 
            // $sipr_room_session_reservation =
            // SiprRoomSessionReservationRequest::select()
            // ->where(SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME, '=', $sipr_room_reservation[SiprRoomReservationRequest::COLUMN_ID_ITS_NAME])
            // ->where(SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME, '=', $id_room_session)
            // ->first()
            // ??
            // SiprRoomSessionReservationRequest::create([
            // "{$column_table_room_session_reservation_ID_its_name}" => $id_room_session_reservation,
            // "{$column_table_room_session_reservation_USER_ID_its_name}" => $user_id,
            // "{$column_table_room_session_reservation_ROOM_RESERVATION_ID_its_name}" => $id_room_reservation,
            // "{$column_table_room_session_reservation_ROOM_SESSION_ID_its_name}" => $id_room_session,
            // "{$column_table_room_session_reservation_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays($days_added),
            // "{$column_table_room_session_reservation_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_table_room_session_reservation_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // ]);
            // $id_room_session++;
            // }
            // 
            // $id_room_reservation++;
            // $days_added++;
            // $room_id++;
            // }
            // 
            // $id_room_reservation = 1;
            // $days_added = 1;
            // $room_id = 1;
            // $user_id = 3;
            // $status = null;
            // $determined_at = null;
            // 
            // for ($iteration_room_reservation = 0; $iteration_room_reservation < 15; $iteration_room_reservation++) {
            // 
            // if ($iteration_room_reservation < 6) {
            // $status = "PENDING";
            // }
            // 
            // if ($iteration_room_reservation >= 6 && $iteration_room_reservation <= 10) {
            // $status = "ACCEPTED";
            // $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            // }
            // 
            // if ($iteration_room_reservation > 10) {
            // $status = "REJECTED";
            // $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            // }
            // 
            // $sipr_room_reservation = SiprRoomReservationRequest::select()
            // ->where(SiprRoomReservationRequest::COLUMN_ID_ITS_NAME, '=', $id_room_reservation)
            // ->where(SiprRoomReservationRequest::COLUMN_USER_ID_ITS_NAME, '=', $user_id)
            // ->where(SiprRoomReservationRequest::COLUMN_ROOM_ID_ITS_NAME, '=', $room_id)
            // ->first();
            // $sipr_room_reservation = $sipr_room_reservation === null ? SiprRoomReservationRequest::create([
            // "{$column_table_room_reservation_ID_its_name}" => $id_room_reservation,
            // "{$column_table_room_reservation_USER_ID_its_name}" => $user_id,
            // "{$column_table_room_reservation_ROOM_ID_its_name}" => $room_id,
            // "{$column_table_room_reservation_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays($days_added),
            // "{$column_table_room_reservation_DETERMINED_AT_its_name}" => $determined_at,
            // "{$column_table_room_reservation_STATUS_its_name}" => $status,
            // "{$column_table_room_reservation_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_table_room_reservation_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // ]) : $sipr_room_reservation;
            // 
            // $id_room_session = 1;
            // for ($iteration_room_session_reservation = 0; $iteration_room_session_reservation < 3; $iteration_room_session_reservation++) {
            // 
            // $sipr_room_session_reservation = SiprRoomSessionReservationRequest::select()
            // ->where(SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME, '=', $id_room_reservation)
            // ->where(SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME, '=', $id_room_session)
            // ->first();
            // $sipr_room_session_reservation = $sipr_room_session_reservation === null ? SiprRoomSessionReservationRequest::create([
            // "{$column_table_room_session_reservation_ID_its_name}" => $id_room_session_reservation,
            // "{$column_table_room_session_reservation_USER_ID_its_name}" => $user_id,
            // "{$column_table_room_session_reservation_ROOM_RESERVATION_ID_its_name}" => $id_room_reservation,
            // "{$column_table_room_session_reservation_ROOM_SESSION_ID_its_name}" => $id_room_session,
            // "{$column_table_room_session_reservation_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays($days_added),
            // "{$column_table_room_session_reservation_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_table_room_session_reservation_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // ]) : $sipr_room_session_reservation;
            // $id_room_session++;
            // }
            // 
            // $id_room_reservation++;
            // $days_added++;
            // $room_id++;
            // }
            // 

        });
    }
}
