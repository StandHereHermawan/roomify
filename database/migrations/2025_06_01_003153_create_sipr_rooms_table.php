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
                ->string('room_code', 255)
                ->nullable(false)
                ->unique();

            $table
                ->string('name', 255)
                ->nullable()
                ->default('Belum Ada Nama.');

            $table
                ->float('meter_room_height')
                ->nullable(true);

            $table
                ->float('meter_squared_floor_wide')
                ->nullable(true);

            $table
                ->softDeletesDatetime()
                ->nullable();

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

        function random_double($min = 0, $max = 1): float
        {
            return $min + mt_rand() / mt_getrandmax() * ($max - $min);
        }


        DB::transaction(function () {
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
