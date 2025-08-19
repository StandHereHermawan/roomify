<?php

use App\Domains\User\Model\SiprUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprUser::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->string('username')
                ->unique()
                ->nullable(false);

            $table
                ->string('name')
                ->nullable();

            $table
                ->string('password')
                ->nullable(false);

            $table
                ->dateTime('created_at')
                ->nullable(true)
                ->useCurrent();

            $table
                ->dateTime('updated_at')
                ->nullable(true)
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table->softDeletesDatetime();
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprUser::TABLE_NAME);
    }
};
