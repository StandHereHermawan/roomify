<?php

namespace Database\Seeders;

use App\Domains\Schedule\Model\SiprRoomReservationRequest;
use App\Domains\Schedule\Model\SiprRoomSessionReservationRequest;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiprRoomReservationAndRoomSessionReservationSeeder extends Seeder
{
    private $tableName = \App\Domains\Room\Model\SiprRoom::TABLE_NAME;

    /**
     * Run the database seeds.
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

        $id_room_reservation = 1;
        $days_added = 1;
        $room_id = 1;
        $status = null;
        $determined_at = null;

        DB::beginTransaction();
        for ($iteration_room_reservation = 0; $iteration_room_reservation < 10; $iteration_room_reservation++) {
            
            if ($iteration_room_reservation < 6) {
                $status = "PENDING";
            }

            if ($iteration_room_reservation >= 6 && $iteration_room_reservation <= 8) {
                $status = "ACCEPTED";
                $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            }

            if ($iteration_room_reservation > 8) {
                $status = "REJECTED";
                $determined_at = \Illuminate\Support\Carbon::now()->addDays($days_added);
            }

            DB::table(SiprRoomReservationRequest::TABLE_NAME)->insert([
                "{$column_table_room_reservation_ID_its_name}" => $id_room_reservation,
                "{$column_table_room_reservation_USER_ID_its_name}" => "2",
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
                    "{$column_table_room_session_reservation_USER_ID_its_name}" => "2",
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
    }
}