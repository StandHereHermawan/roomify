<?php

use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprUserHasSecondaryEmail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprUserHasSecondaryEmail::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->bigInteger("user_id")
                ->unsigned();

            $table
                ->bigInteger("email_id")
                ->unsigned();

            $table
                ->foreign("user_id")
                ->references("id")
                ->on(SiprUser::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign("email_id")
                ->references("id")
                ->on(SiprSecondaryEmail::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(["user_id", "email_id"], "unique_combine_user_id_and_email_id");
            $table->softDeletesDatetime();
            $table->datetimes();
        });

        DB::table(SiprUserHasSecondaryEmail::TABLE_NAME)->insert([
            "user_id" => '2',
            "email_id" => '1',
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprUserHasSecondaryEmail::TABLE_NAME);
    }
};
