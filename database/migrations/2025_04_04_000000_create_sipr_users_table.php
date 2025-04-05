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
        Schema::create('sipr_users', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned()->nullable(false);
            $table->string('username')->unique();
            $table->string('name');
            $table->string('password');
            $table->softDeletesDatetime();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipr_users');
    }
};
