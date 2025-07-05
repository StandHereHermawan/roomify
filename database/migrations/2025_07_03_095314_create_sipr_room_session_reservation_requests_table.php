<?php

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;
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
        Schema::create(SiprRoomSessionReservationRequest::TABLE_NAME, function (Blueprint $table) {
            $table->id()->primary(true);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('room_session_id')->nullable();
            $table->unsignedBigInteger('room_reservation_id')->nullable();

            $table
                ->foreign("room_reservation_id")
                ->references("id")
                ->on(SiprRoomSessionReservationRequest::TABLE_NAME)
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprRoomSessionReservationRequest::TABLE_NAME);
    }
};
