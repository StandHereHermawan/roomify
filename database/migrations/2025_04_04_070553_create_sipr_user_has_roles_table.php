<?php

use App\Domains\User\Model\SiprUserHasRole;
use App\Domains\User\Model\SiprUser;
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
        Schema::create(SiprUserHasRole::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->bigInteger("user_id")
                ->unsigned();

            $table
                ->bigInteger("role_id")
                ->unsigned();

            $table
                ->foreign("user_id")
                ->references("id")
                ->on(SiprUser::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign("role_id")
                ->references("id")
                ->on(SiprRole::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('sipr_user_has_roles');
    }
};
