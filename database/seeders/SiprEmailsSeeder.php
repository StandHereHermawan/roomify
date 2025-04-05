<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiprEmailsSeeder extends Seeder
{
    private $tableName = "sipr_emails";

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            for ($i = 0; $i < 5; $i++) {
                $userNumber = $i + 1;
                DB::table($this->tableName)->insert([
                    "email" => "userEmail{$userNumber}@localhost.com",
                    "created_at" => Carbon::now()->addHours(7)
                ]);
            }
        });
    }
}
