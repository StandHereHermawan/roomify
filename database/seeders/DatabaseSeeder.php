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

class DatabaseSeeder extends Seeder
{
    private $tableName = SiprUser::TABLE_NAME;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $column_table_room_reservation_ID_its_name = SiprRoomReservationRequest::COLUMN_ID_ITS_NAME;
        $column_table_room_reservation_USER_ID_its_name = SiprRoomReservationRequest::COLUMN_USER_ID_ITS_NAME;
        $column_table_room_reservation_ROOM_ID_its_name = SiprRoomReservationRequest::COLUMN_ROOM_ID_ITS_NAME;
        $column_table_room_reservation_RESERVATION_DATE_its_name = SiprRoomReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME;
        $column_table_room_reservation_DETERMINED_AT_its_name = SiprRoomReservationRequest::COLUMN_DETERMINED_AT_ITS_NAME;
        $column_table_room_reservation_CREATED_AT_its_name = SiprRoomReservationRequest::CREATED_AT;
        $column_table_room_reservation_UPDATED_AT_its_name = SiprRoomReservationRequest::UPDATED_AT;
        $column_table_room_reservation_STATUS_its_name = SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME;

        //  $column_table_room_session_reservation_ID_its_name = SiprRoomSessionReservationRequest::COLUMN_ID_ITS_NAME;
        $column_table_room_session_reservation_USER_ID_its_name = SiprRoomSessionReservationRequest::COLUMN_USER_ID_ITS_NAME;
        $column_table_room_session_reservation_ROOM_RESERVATION_ID_its_name = SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME;
        $column_table_room_session_reservation_ROOM_SESSION_ID_its_name = SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME;
        $column_table_room_session_reservation_RESERVATION_DATE_its_name = SiprRoomSessionReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME;
        $column_table_room_session_reservation_CREATED_AT_its_name = SiprRoomSessionReservationRequest::CREATED_AT;
        $column_table_room_session_reservation_UPDATED_AT_its_name = SiprRoomSessionReservationRequest::UPDATED_AT;

        DB::beginTransaction();

        $record_model_super_admin = null;
        $record_model_terry_davis = null;
        $record_model_david_hansson = null;

        /*
        |
        |
        |   User Seeder
        */ 
        {
            $record_model_super_admin = SiprUser::create([
                "username" => "superadmin",
                "name" => "Super Admin",
                "password" => Hash::make('Rahasia@1234'),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            $record_model_terry_davis = SiprUser::create([
                "username" => "terryandrewdavis",
                "name" => "Terry Andrew Davis",
                "password" => Hash::make('Rahasia@1234'),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            $record_model_david_hansson = SiprUser::create([
                "username" => "davidheinemeierhansson",
                "name" => "David Heinemeier Hansson",
                "password" => Hash::make('Rahasia@1234'),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            for ($iteration = 0; $iteration < 5; $iteration++) {
                $userNumber = $iteration + 1;
                DB::table($this->tableName)->insert([
                    "username" => "username{$userNumber}",
                    "name" => "name{$userNumber}",
                    "password" => Hash::make("Rahasia@1234"),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                    "created_at" => \Illuminate\Support\Carbon::now()
                ]);
            }
        }


        /*
        |
        |
        |   email seeder and email relation with user table.
        */ 
        {
            $email_super_admin_record_model = SiprSecondaryEmail::create([
                "email" => "super.admin@localhost.com",
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            $email_terry_record_model = SiprSecondaryEmail::create([
                "email" => "terry.davis@localhost.com",
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            $email_david_record_model = SiprSecondaryEmail::create([
                "email" => "david.hansson@localhost.com",
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprUserHasSecondaryEmail::create([
                "user_id" => $record_model_terry_davis->getId(),
                "email_id" => $email_terry_record_model->getId(),
            ]);

            SiprUserHasSecondaryEmail::create([
                "user_id" => $record_model_david_hansson->getId(),
                "email_id" => $email_david_record_model->getId(),
            ]);

            SiprUserHasSecondaryEmail::create([
                "user_id" => $record_model_super_admin->getId(),
                "email_id" => $email_super_admin_record_model->getId(),
            ]);
        }

        /*
        |
        |
        |   phone number seeder and phone number relation
        */ 
        {
            $terry_phone_number_record = SiprPhoneNumber::create([
                "phone_number" =>
                    "+62-8" .
                    random_int(10, 99) . "-" .
                    random_int(1000, 9999) . "-" .
                    random_int(1000, 9999),
                "created_at" => \Illuminate\Support\Carbon::now()
                    ->addHours(7)
            ]);

            $super_admin_phone_number_record = SiprPhoneNumber::create([
                "phone_number" =>
                    "+62-8" .
                    random_int(10, 99) . "-" .
                    random_int(1000, 9999) . "-" .
                    random_int(1000, 9999),
                "created_at" => \Illuminate\Support\Carbon::now()
                    ->addHours(7)
            ]);

            $david_phone_number_record = SiprPhoneNumber::create([
                "phone_number" =>
                    "+62-8" .
                    random_int(10, 99) . "-" .
                    random_int(1000, 9999) . "-" .
                    random_int(1000, 9999),
                "created_at" => \Illuminate\Support\Carbon::now()
                    ->addHours(7)
            ]);

            SiprUserHasPhoneNumber::create([
                "user_id" => $record_model_terry_davis->getId(),
                "phone_number_id" => $terry_phone_number_record->getId(),
            ]);

            SiprUserHasPhoneNumber::create([
                "user_id" => $record_model_david_hansson->getId(),
                "phone_number_id" => $david_phone_number_record->getId(),
            ]);

            SiprUserHasPhoneNumber::create([
                "user_id" => $record_model_super_admin->getId(),
                "phone_number_id" => $super_admin_phone_number_record->getId(),
            ]);
        }

        /*
        |
        |
        |   role seeder and role relation
        */ 
        {
            $super_admin_role_record = SiprRole::create([
                "role" => "SUPER_ADMIN",
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            $guest_role_record = SiprRole::create([
                "role" => "GUEST",
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            $operator_role_record = SiprRole::create([
                "role" => "OPERATOR",
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprUserHasRole::create([
                "user_id" => $record_model_super_admin->getId(),
                "role_id" => $super_admin_role_record->getId(),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprUserHasRole::create([
                "user_id" => $record_model_terry_davis->getId(),
                "role_id" => $guest_role_record->getId(),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprUserHasRole::create([
                "user_id" => $record_model_david_hansson->getId(),
                "role_id" => $guest_role_record->getId(),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);
        }

        /*
        |
        |   room seeder.
        |
        */ 
        {
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

                DB::table(SiprRoom::TABLE_NAME)->insert([
                    "room_code" => $number,
                    "name" => fake()->randomElement(['Ruang-Biasa', 'Lab']),
                    "meter_room_height" => random_double(2.5, 3.5),
                    "meter_squared_floor_wide" => random_double(7.5, 12.5),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]);
            }
        }

        /*
        |
        |
        |   room session seeder.
        */ 
        {
            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(7)->minute(0)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(7)->minute(49)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(7)->minute(50)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(8)->minute(39)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(8)->minute(40)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(9)->minute(29)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(9)->minute(30)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(10)->minute(19)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(10)->minute(20)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(11)->minute(9)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(11)->minute(10)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(12)->minute(0)->second(00),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(12)->minute(50)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(13)->minute(39)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(13)->minute(40)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(14)->minute(29)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(14)->minute(30)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(15)->minute(19)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(15)->minute(20)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(16)->minute(9)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(16)->minute(10)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(16)->minute(59)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            SiprRoomSession::create([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(17)->minute(00)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(17)->minute(50)->second(00),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);
        }

        $id_room_reservation = 1;
        $days_added = 0;
        $room_id = 1;
        $user_id = 2;
        $status = null;
        $determined_at = null;

        for ($iteration_room_reservation = 0; $iteration_room_reservation < 15; $iteration_room_reservation++) {

            if ($iteration_room_reservation < 6) {
                $status = "PENDING";
            }

            if ($iteration_room_reservation >= 6 && $iteration_room_reservation <= 10) {
                $status = "ACCEPTED";
                $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            }

            if ($iteration_room_reservation > 10) {
                $status = "REJECTED";
                $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            }

            SiprRoomReservationRequest::create([
                "{$column_table_room_reservation_ID_its_name}" => $id_room_reservation,
                "{$column_table_room_reservation_USER_ID_its_name}" => $user_id,
                "{$column_table_room_reservation_ROOM_ID_its_name}" => $room_id,
                "{$column_table_room_reservation_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays($days_added),
                "{$column_table_room_reservation_DETERMINED_AT_its_name}" => $determined_at,
                "{$column_table_room_reservation_STATUS_its_name}" => $status,
                "{$column_table_room_reservation_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
                "{$column_table_room_reservation_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            ]);


            $id_room_session = 1;
            for ($iteration_room_session_reservation = 0; $iteration_room_session_reservation < 3; $iteration_room_session_reservation++) {

                DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
                 // "{$column_table_room_session_reservation_ID_its_name}" => $id_room_session_reservation,
                    "{$column_table_room_session_reservation_USER_ID_its_name}" => $user_id,
                    "{$column_table_room_session_reservation_ROOM_RESERVATION_ID_its_name}" => $id_room_reservation,
                    "{$column_table_room_session_reservation_ROOM_SESSION_ID_its_name}" => $id_room_session,
                    "{$column_table_room_session_reservation_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays($days_added),
                    "{$column_table_room_session_reservation_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
                    "{$column_table_room_session_reservation_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
                ]);
                $id_room_session++;
            }

            $id_room_reservation++;
            $days_added++;
            $room_id++;
        }

        // $id_room_reservation = 1;
        // $days_added = 1;
        // $room_id = 1;
        $user_id = 3;
        $status = null;
        $determined_at = null;

        for ($iteration_room_reservation = 0; $iteration_room_reservation < 15; $iteration_room_reservation++) {

            if ($iteration_room_reservation < 6) {
                $status = "PENDING";
            }

            if ($iteration_room_reservation >= 6 && $iteration_room_reservation <= 10) {
                $status = "ACCEPTED";
                $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            }

            if ($iteration_room_reservation > 10) {
                $status = "REJECTED";
                $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            }

            DB::table(SiprRoomReservationRequest::TABLE_NAME)->insert([
                "{$column_table_room_reservation_ID_its_name}" => $id_room_reservation,
                "{$column_table_room_reservation_USER_ID_its_name}" => $user_id,
                "{$column_table_room_reservation_ROOM_ID_its_name}" => $room_id,
                "{$column_table_room_reservation_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays($days_added),
                "{$column_table_room_reservation_DETERMINED_AT_its_name}" => $determined_at,
                "{$column_table_room_reservation_STATUS_its_name}" => $status,
                "{$column_table_room_reservation_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
                "{$column_table_room_reservation_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            ]);


            $id_room_session = 1;
            for ($iteration_room_session_reservation = 0; $iteration_room_session_reservation < 3; $iteration_room_session_reservation++) {

                DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
                    // "{$column_table_room_session_reservation_ID_its_name}" => $id_room_session_reservation,
                    "{$column_table_room_session_reservation_USER_ID_its_name}" => $user_id,
                    "{$column_table_room_session_reservation_ROOM_RESERVATION_ID_its_name}" => $id_room_reservation,
                    "{$column_table_room_session_reservation_ROOM_SESSION_ID_its_name}" => $id_room_session,
                    "{$column_table_room_session_reservation_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays($days_added),
                    "{$column_table_room_session_reservation_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
                    "{$column_table_room_session_reservation_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
                ]);
                $id_room_session++;
            }

            $id_room_reservation++;
            $days_added++;
            $room_id++;
        }

        DB::commit();

        // 
        // 
        // \App\Models\User::factory(10)->create();
        // 
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // 
        // 
    }
}
