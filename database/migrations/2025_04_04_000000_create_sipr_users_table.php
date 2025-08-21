<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const TABLE_NAME = "sipr_users";
    private const ID = "id";
    private const USERNAME = "username";
    private const NAME = "name";
    private const PASSWORD = "password";
    private const REMEMBER_TOKEN = "remember_token";
    private const CREATED_AT = "created_at";
    private const UPDATED_AT = "updated_at";
    private const DELETED_AT = "deleted_at";

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id(self::ID)
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->string(self::USERNAME)
                ->unique()
                ->nullable(false);

            $table
                ->string(self::NAME)
                ->nullable();

            $table
                ->string(self::PASSWORD)
                ->nullable(false);

            $table
                ->dateTime(self::CREATED_AT)
                ->nullable(true)
                ->useCurrent();

            $table
                ->dateTime(self::UPDATED_AT)
                ->nullable(true)
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table
                ->softDeletesDatetime(self::DELETED_AT)
                ->nullable();
                
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
