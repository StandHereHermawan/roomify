<?php

use App\Domains\User\Model\SiprUserHasSession;
use App\Domains\User\Model\SiprUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprUserHasSession::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->bigInteger("user_id")
                ->unsigned();

         // $table
         //     ->string('username')
         //     ->unique();

            $table
                ->string('session')
                ->unique();

            $table
                ->foreign("user_id")
                ->references("id")
                ->on(SiprUser::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

         // $table
         //     ->foreign("username")
         //     ->references("username")
         //     ->on(SiprUser::TABLE_NAME)
         //     ->cascadeOnUpdate()
         //     ->cascadeOnDelete();

            $table
                ->dateTime("expired_at");

            $table
                ->datetime("created_at");

         // $table
         //     ->softDeletesDatetime();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipr_user_has_sessions');
    }
};
