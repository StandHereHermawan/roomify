<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiprUsersSeeder extends Seeder
{
    private $tableName = "sipr_users";

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            for ($i = 0; $i < 5; $i++) {
                $userNumber = $i + 1;
                DB::table($this->tableName)->insert([
                    "username" => "username{$userNumber}",
                    "name" => "name{$userNumber}",
                    "password" => Hash::make("rahasia{$userNumber}", ["rounds" => 4]),
                    "created_at" => Carbon::now()->addHours(7)
                ]);
            }
        });
    }
}
