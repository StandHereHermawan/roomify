<?php

use App\Domains\Room\Model\SiprRoom;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprRoom::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->string('name', 255)
                ->nullable(false);

            $table
                ->float('meter_room_height')
                ->nullable(true);

            $table
                ->float('meter_squared_room_volume')
                ->nullable(true);

            $table
                ->softDeletesDatetime();

            $table
                ->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprRoom::TABLE_NAME);
    }
};
