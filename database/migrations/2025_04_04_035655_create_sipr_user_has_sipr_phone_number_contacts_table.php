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
        Schema::create('sipr_usr_has_sipr_pho_num_cont', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("phone_number_contacts_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("sipr_users")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign("phone_number_contacts_id")->references("id")->on("sipr_phone_number_contacts")->cascadeOnUpdate()->cascadeOnDelete();
            $table->softDeletesDatetime();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipr_usr_has_sipr_pho_num_cont');
    }
};
