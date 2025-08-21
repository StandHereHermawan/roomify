<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const TABLE_NAME = "sipr_user_has_roles";
    private const TABLE_USER = "sipr_users";
    private const ID = "id";
    private const TABLE_USER_COLUMN_ID = "id";
    private const USER_ID = "user_id";
    private const TABLE_ROLE = "sipr_roles";
    private const TABLE_ROLE_COLUMN_ID = "id";
    private const ROLE_ID = "role_id";
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
                ->id()
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->bigInteger(self::USER_ID)
                ->unsigned();

            $table
                ->bigInteger(self::ROLE_ID)
                ->unsigned();

                $table
                ->foreign(self::USER_ID)
                ->references(self::TABLE_USER_COLUMN_ID)
                ->on(self::TABLE_USER)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign(self::ROLE_ID)
                ->references(self::TABLE_ROLE_COLUMN_ID)
                ->on(self::TABLE_ROLE)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->softDeletesDatetime(self::DELETED_AT)
                ->nullable();

            $table
                ->dateTime(self::CREATED_AT)
                ->nullable(true)
                ->useCurrent();

            $table
                ->dateTime(self::UPDATED_AT)
                ->nullable(true)
                ->useCurrent()
                ->useCurrentOnUpdate();
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
