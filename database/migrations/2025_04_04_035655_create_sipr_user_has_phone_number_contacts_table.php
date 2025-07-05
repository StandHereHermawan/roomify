<?php

use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprUserHasPhoneNumber;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprUserHasPhoneNumber::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->bigInteger("user_id")
                ->unsigned();

            $table
                ->bigInteger("phone_number_id")
                ->unsigned();

            $table
                ->foreign("user_id")
                ->references("id")
                ->on(SiprUser::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign("phone_number_id")
                ->references("id")
                ->on(SiprPhoneNumber::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
                
            $table->unique(["user_id", "phone_number_id"]);
            $table->softDeletesDatetime();
            $table->datetimes();
        });

        DB::table(SiprUserHasPhoneNumber::TABLE_NAME)->insert([
            "user_id" => '2',
            "phone_number_id" => '1',
            "created_at" => \Illuminate\Support\Carbon::now(),
            "updated_at" => \Illuminate\Support\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprUserHasPhoneNumber::TABLE_NAME);
    }
};
