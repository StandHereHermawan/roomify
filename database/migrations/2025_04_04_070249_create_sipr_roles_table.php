<?php

use App\Domains\User\Model\SiprRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const ID = "id";
    private const ROLE = "role";
    private const CREATED_AT = "created_at";
    private const UPDATED_AT = "updated_at";
    private const DELETED_AT = "deleted_at";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprRole::TABLE_NAME, function (Blueprint $table) {
            $table
                ->id(self::ID)
                ->autoIncrement()
                ->unsigned()
                ->nullable(false);

            $table
                ->string(self::ROLE, 30)
                ->unique();

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
        Schema::dropIfExists(SiprRole::TABLE_NAME);
    }
};
