<?php

use App\Domains\User\Model\SiprRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprRole::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->string("role", 30)
                ->unique();

            $table
                ->softDeletesDatetime();

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

        DB::table(SiprRole::TABLE_NAME)->insert([
            "role" => "SUPER_ADMIN",
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);

        DB::table(SiprRole::TABLE_NAME)->insert([
            "role" => "GUEST",
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprRole::TABLE_NAME);
    }
};
