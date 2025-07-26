<?php

use App\Domains\Room\Model\SiprRoom;
use App\Domains\User\Model\SiprUser;
use App\Domains\Schedule\Model\SiprRoomReservationRequest;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // $column_ID_its_name = SiprRoomReservationRequest::COLUMN_ID_ITS_NAME;
        // $column_USER_ID_its_name = SiprRoomReservationRequest::COLUMN_USER_ID_ITS_NAME;
        // $column_ROOM_ID_its_name = SiprRoomReservationRequest::COLUMN_ROOM_ID_ITS_NAME;
        // $column_RESERVATION_DATE_its_name = SiprRoomReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME;
        // $column_CREATED_AT_its_name = SiprRoomReservationRequest::CREATED_AT;
        // $column_UPDATED_AT_its_name = SiprRoomReservationRequest::UPDATED_AT;
        // $column_STATUS_its_name = SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME;

        Schema::create(SiprRoomReservationRequest::TABLE_NAME, function (Blueprint $table) {
            $table->id()->primary(true);
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table
                ->foreign("room_id")
                ->references("id")
                ->on(SiprRoom::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->string('status', 255)
                ->nullable()
                ->default('PENDING');

            $table
                ->foreign("user_id")
                ->references("id")
                ->on(SiprUser::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date('reservation_date');
            $table->softDeletes();

            $table
            ->dateTime('determined_at')
            ->nullable(true);

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
        // 
        // $id = 1;
        // 
        // DB::table(SiprRoomReservationRequest::TABLE_NAME)->insert([
            // "{$column_ID_its_name}" => $id,
            // "{$column_USER_ID_its_name}" => "2",
            // "{$column_ROOM_ID_its_name}" => "1",
            // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
            // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // $id++;
        // 
        // DB::table(SiprRoomReservationRequest::TABLE_NAME)->insert([
            // "{$column_ID_its_name}" => $id,
            // "{$column_USER_ID_its_name}" => "3",
            // "{$column_ROOM_ID_its_name}" => "2",
            // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
            // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // $id++;
        // 
        // DB::table(SiprRoomReservationRequest::TABLE_NAME)->insert([
            // "{$column_ID_its_name}" => $id,
            // "{$column_USER_ID_its_name}" => "1",
            // "{$column_ROOM_ID_its_name}" => "3",
            // "{$column_STATUS_its_name}" => "ACCEPTED",
            // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
            // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // $id++;
        // 
        // DB::table(SiprRoomReservationRequest::TABLE_NAME)->insert([
            // "{$column_ID_its_name}" => $id,
            // "{$column_USER_ID_its_name}" => "1",
            // "{$column_ROOM_ID_its_name}" => "4",
            // "{$column_STATUS_its_name}" => "ACCEPTED",
            // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(7),
            // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // $id++;
        // 
        // DB::table(SiprRoomReservationRequest::TABLE_NAME)->insert([
            // "{$column_ID_its_name}" => $id,
            // "{$column_USER_ID_its_name}" => "2",
            // "{$column_ROOM_ID_its_name}" => "5",
            // "{$column_STATUS_its_name}" => "REJECTED",
            // "{$column_RESERVATION_DATE_its_name}" => \Illuminate\Support\Carbon::now()->addDays(8),
            // "{$column_CREATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
            // "{$column_UPDATED_AT_its_name}" => \Illuminate\Support\Carbon::now(),
        // ]);
        // $id++;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprRoomReservationRequest::TABLE_NAME);
    }
};
