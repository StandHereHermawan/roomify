<?php

use App\Domains\Room\Model\SiprRoomSession;
use App\Domains\Schedule\Model\SiprRoomReservationRequest;
use App\Domains\Schedule\Model\SiprRoomSessionReservationRequest;
use App\Domains\User\Model\SiprUser;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $column_ID_its_name = SiprRoomSessionReservationRequest::COLUMN_ID_ITS_NAME;
        $column_USER_ID_its_name = SiprRoomSessionReservationRequest::COLUMN_USER_ID_ITS_NAME;
        $column_ROOM_RESERVATION_ID_its_name = SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME;
        $column_ROOM_SESSION_ID_its_name = SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME;
        $column_RESERVATION_DATE_its_name = SiprRoomSessionReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME;
        $column_CREATED_AT_its_name = SiprRoomSessionReservationRequest::CREATED_AT;
        $column_UPDATED_AT_its_name = SiprRoomSessionReservationRequest::UPDATED_AT;

        Schema::create(SiprRoomSessionReservationRequest::TABLE_NAME, function (Blueprint $table) {
            $table->id()->primary(true);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('room_session_id')->nullable();
            $table->unsignedBigInteger('room_reservation_id')->nullable();

            $table
                ->foreign("room_reservation_id")
                ->references("id")
                ->on(SiprRoomReservationRequest::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign("room_session_id")
                ->references("id")
                ->on(SiprRoomSession::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign("user_id")
                ->references("id")
                ->on(SiprUser::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date('reservation_date');
            $table->softDeletes();

            $table
                ->dateTime('created_at')
                ->nullable(true)
                ->useCurrent();

            $table
                ->dateTime('updated_at')
                ->nullable(true)
                ->useCurrent()
                ->useCurrentOnUpdate();
        });

        (new \Database\Seeders\DatabaseSeeder)->run();

        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "1",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "1",
        // "{$column_ROOM_SESSION_ID_its_name}" => "1",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "2",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "1",
        // "{$column_ROOM_SESSION_ID_its_name}" => "2",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "3",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "1",
        // "{$column_ROOM_SESSION_ID_its_name}" => "3",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "4",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "2",
        // "{$column_ROOM_SESSION_ID_its_name}" => "4",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "5",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "2",
        // "{$column_ROOM_SESSION_ID_its_name}" => "5",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "6",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "2",
        // "{$column_ROOM_SESSION_ID_its_name}" => "6",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "1",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "4",
        // "{$column_ROOM_SESSION_ID_its_name}" => "1",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "2",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "4",
        // "{$column_ROOM_SESSION_ID_its_name}" => "2",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "3",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "4",
        // "{$column_ROOM_SESSION_ID_its_name}" => "3",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "1",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "3",
        // "{$column_ROOM_SESSION_ID_its_name}" => "1",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "2",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "3",
        // "{$column_ROOM_SESSION_ID_its_name}" => "2",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "3",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "3",
        // "{$column_ROOM_SESSION_ID_its_name}" => "3",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "1",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "5",
        // "{$column_ROOM_SESSION_ID_its_name}" => "1",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(8),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "2",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "5",
        // "{$column_ROOM_SESSION_ID_its_name}" => "2",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(8),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // 
        // DB::table(SiprRoomSessionReservationRequest::TABLE_NAME)->insert([
        // "{$column_ID_its_name}" => "3",
        // "{$column_USER_ID_its_name}" => "2",
        // "{$column_ROOM_RESERVATION_ID_its_name}" => "5",
        // "{$column_ROOM_SESSION_ID_its_name}" => "3",
        // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(8),
        // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprRoomSessionReservationRequest::TABLE_NAME);
    }
};
