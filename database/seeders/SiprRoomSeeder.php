<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiprRoomSeeder extends Seeder
{
    private $tableName = \App\Domains\Room\Model\SiprRoom::TABLE_NAME;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            for ($i = 0; $i < 24; $i++) {
                $roomNumber = $i + 1;
                $number = null;

                if ($i < 9) {
                    $number = "B-30{$roomNumber}";
                }

                if ($i >= 9) {
                    $number = "B-3{$roomNumber}";
                }

                DB::table($this->tableName)->insert([
                    "room_code" => $number,
                    "name" => fake()->randomElement(['Ruang-Biasa', 'Lab']),
                    "meter_room_height" => random_int(3, 4),
                    "meter_squared_floor_wide" => random_int(5, 10),
                    "created_at" => \Illuminate\Support\Carbon::now(),
                    "updated_at" => \Illuminate\Support\Carbon::now(),
                ]);
            }
        });
    }
}
