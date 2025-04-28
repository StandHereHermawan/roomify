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
        Schema::create('sipr_user_has_emails', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("email_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("sipr_users")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign("email_id")->references("id")->on("sipr_emails")->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(["user_id", "email_id"], "unique_combine_column_user_id_and_email_id");
            $table->softDeletesDatetime();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipr_user_has_emails');
    }
};
