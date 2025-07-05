<?php

use App\Domains\User\Model\SiprUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprUser::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->string('username')
                ->unique()
                ->nullable(false);

            $table
                ->string('name')
                ->nullable();

            $table
                ->string('password')
                ->nullable(false);

            $table
                ->dateTime('created_at')
                ->nullable(true)
                ->useCurrent();

            $table
                ->dateTime('updated_at')
                ->nullable(true)
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table->softDeletesDatetime();
            $table->rememberToken();

        });

        DB::table(SiprUser::TABLE_NAME)->insert([
            "username" => "superadmin",
            "name" => "Super Admin",
            "password" => Hash::make('Rahasia@1234'),
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);

        DB::table(SiprUser::TABLE_NAME)->insert([
            "username" => "terryandrewdavis",
            "name" => "Terry Andrew Davis",
            "password" => Hash::make('Rahasia@1234'),
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprUser::TABLE_NAME);
    }
};
