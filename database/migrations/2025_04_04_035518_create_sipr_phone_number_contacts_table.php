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
        Schema::dropIfExists(SiprPhoneNumber::TABLE_NAME);
    }
};
