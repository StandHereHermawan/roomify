<?php

use App\Domains\Schedule\Model\SiprRoomReservationRequest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const ID = "id";
    private const CREATED_AT = "created_at";
    private const UPDATED_AT = "updated_at";
    private const DELETED_AT = "deleted_at";
    private const TABLE_NAME = "sipr_room_reservation_requests";
    private const SESSION_START = 'room_session_start';
    private const SESSION_END = 'room_session_end';
    private const TABLE_ROOM = "sipr_rooms";
    private const TABLE_ROOM_COLUMN_ID = "id";
    private const ROOM_ID = "room_id";
    private const STATUS = "status";
    private const DETERMINED_AT = "determined_at";
    private const RESERVATION_DATE = "reservation_date";
    private const TABLE_USER_COLUMN_ID = "id";
    private const TABLE_USER = "sipr_users";
    private const USER_ID = "user_id";

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id(self::ID)
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table->unsignedBigInteger(self::ROOM_ID)->nullable();
            $table->unsignedBigInteger(self::USER_ID)->nullable();

            $table
                ->foreign(self::ROOM_ID)
                ->references(self::TABLE_ROOM_COLUMN_ID)
                ->on(self::TABLE_ROOM)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->string(self::STATUS, 255)
                ->nullable()
                ->default('PENDING');

            $table
                ->foreign(self::USER_ID)
                ->references(self::TABLE_USER_COLUMN_ID)
                ->on(self::TABLE_USER)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date(self::RESERVATION_DATE);

            $table
                ->dateTime(self::DETERMINED_AT)
                ->nullable(true);

            $table
                ->softDeletesDatetime(self::DELETED_AT)
                ->nullable();

            $table
                ->dateTime(self::CREATED_AT)
                ->nullable(true)
                ->useCurrent();

            $table
                ->dateTime(self::UPDATED_AT)
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
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
