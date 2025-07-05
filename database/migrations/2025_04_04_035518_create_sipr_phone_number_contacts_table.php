<?php

use App\Domains\User\Model\SiprPhoneNumber;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprPhoneNumber::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->string("phone_number", 20)
                ->unique();

            $table->softDeletesDatetime();
            
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

        DB::table(SiprPhoneNumber::TABLE_NAME)->insert([
            "phone_number" => "+62-812-3456-7890",
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprPhoneNumber::TABLE_NAME);
    }
};
