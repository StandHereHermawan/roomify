<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiprPhoneNumbersSeeder extends Seeder
{
    private $tableName = "sipr_phone_number_contacts";

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            for ($i = 0; $i < 5; $i++) {
                DB::table($this->tableName)->insert([
                    "phone_number" => "+62-8" . random_int(10,99) . "-" . random_int(1000,9999) . "-" . random_int(1000,9999),
                    "created_at" => Carbon::now()->addHours(7)
                ]);
            }
        });
    }
}
