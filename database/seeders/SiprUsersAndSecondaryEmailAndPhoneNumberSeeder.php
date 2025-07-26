<?php

namespace Database\Seeders;

use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprUserHasSecondaryEmail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiprUsersAndSecondaryEmailAndPhoneNumberSeeder extends Seeder
{
    private $tableName = SiprUser::TABLE_NAME;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        $record_model_super_admin = SiprUser::create([
            "username" => "superadmin",
            "name" => "Super Admin",
            "password" => Hash::make('Rahasia@1234'),
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);

        $record_model_terry_davis = SiprUser::create([
            "username" => "terryandrewdavis",
            "name" => "Terry Andrew Davis",
            "password" => Hash::make('Rahasia@1234'),
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);

        $record_model_david_hansson = SiprUser::create([
            "username" => "davidheinemeierhansson",
            "name" => "David Heinemeier Hansson",
            "password" => Hash::make('Rahasia@1234'),
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);

        /*
        |
        |   email seeder and email relation with user table.
        */ {
            $email_super_admin_record_model = SiprSecondaryEmail::create([
                "email" => "terry.davis@localhost.com",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

            $email_terry_record_model = SiprSecondaryEmail::create([
                "email" => "terry.davis@localhost.com",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

            $email_david_record_model = SiprSecondaryEmail::create([
                "email" => "david.hansson@localhost.com",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

            SiprUserHasSecondaryEmail::create([
                "user_id" => $record_model_terry_davis->getId(),
                "email_id" => $email_terry_record_model->getId(),
            ]);

            SiprUserHasSecondaryEmail::create([
                "user_id" => $record_model_david_hansson->getId(),
                "email_id" => $email_david_record_model->getId(),
            ]);

            SiprUserHasSecondaryEmail::create([
                "user_id" => $record_model_super_admin->getId(),
                "email_id" => $email_super_admin_record_model->getId(),
            ]);
        }

        for ($iteration = 0; $iteration < 5; $iteration++) {
            $userNumber = $iteration + 1;
            DB::table($this->tableName)->insert([
                "username" => "username{$userNumber}",
                "name" => "name{$userNumber}",
                "password" => Hash::make("Rahasia@1234"),
                "updated_at" => \Illuminate\Support\Carbon::now(),
                "created_at" => Carbon::now()
            ]);
        }

        DB::commit();
    }
}
