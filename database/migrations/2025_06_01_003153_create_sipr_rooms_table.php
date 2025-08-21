<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const ID = "id";
    private const TABLE_NAME = 'sipr_rooms';
    private const NAME = 'name';
    private const CODE = 'room_code';
    private const HEIGHT = 'meter_room_height';
    private const FLOOR_WIDE = 'meter_squared_floor_wide';
    private const CREATED_AT = "created_at";
    private const UPDATED_AT = "updated_at";
    private const DELETED_AT = "deleted_at";

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

            $table
                ->string(self::CODE, 255)
                ->nullable(false)
                ->unique();

            $table
                ->string(self::NAME, 255)
                ->nullable()
                ->default('Belum Ada Nama.');

            $table
                ->float(self::HEIGHT)
                ->nullable(true);

            $table
                ->float(self::FLOOR_WIDE)
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
