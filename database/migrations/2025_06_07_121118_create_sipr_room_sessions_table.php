<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const ID = "id";
    private const NAME = 'name';
    private const CODE = 'room_code';
    private const HEIGHT = 'meter_room_height';
    private const FLOOR_WIDE = 'meter_squared_floor_wide';
    private const CREATED_AT = "created_at";
    private const UPDATED_AT = "updated_at";
    private const DELETED_AT = "deleted_at";
    private const TABLE_NAME = 'sipr_room_sessions';
    private const SESSION_START = 'room_session_start';
    private const SESSION_END = 'room_session_end';

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

            $table->time(self::SESSION_START)->nullable(false);
            $table->time(self::SESSION_END)->nullable(false);

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
