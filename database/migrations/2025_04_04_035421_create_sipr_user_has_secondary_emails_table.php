<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const TABLE_NAME = "sipr_user_has_emails";
    private const TABLE_EMAIL = "sipr_secondary_emails";
    private const ID = "id";
    private const TABLE_EMAIL_COLUMN_ID = "id";
    private const TABLE_USER_COLUMN_ID = "id";
    private const TABLE_USER = "sipr_users";
    private const USER_ID = "user_id";
    private const EMAIL_ID = "email_id";
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
                ->bigInteger(self::USER_ID)
                ->unsigned();

            $table
                ->bigInteger(self::EMAIL_ID)
                ->unsigned();

            $table
                ->foreign(self::USER_ID)
                ->references(self::TABLE_USER_COLUMN_ID)
                ->on(self::TABLE_USER)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign(self::EMAIL_ID)
                ->references(self::TABLE_EMAIL_COLUMN_ID)
                ->on(self::TABLE_EMAIL)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique([self::USER_ID, self::EMAIL_ID], "unique_combine_user_id_and_email_id");
            
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
