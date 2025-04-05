<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sipr_phone_number_contacts', function (Blueprint $table) {
            $table->id();
            $table->string("phone_number", 20)->unique();
            $table->softDeletesDatetime();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipr_phone_number_contacts');
    }
};
