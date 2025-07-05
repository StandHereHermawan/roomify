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
        Schema::dropIfExists(SiprRoomReservationRequest::TABLE_NAME);
    }
};
