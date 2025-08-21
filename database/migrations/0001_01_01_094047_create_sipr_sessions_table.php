<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    private const TABLE_NAME = "sipr_sessions";
    private const ID = "id";
    private const USER_ID = "user_id";
    private const IP_ADDRESS = "ip_address";
    private const USER_AGENT = "user_agent";
    private const PAYLOAD = "payload";
    private const LAST_ACTIVITY = "last_activity";

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->string(self::ID)->primary();
            $table->foreignId(self::USER_ID)->nullable()->index();
            $table->string(self::IP_ADDRESS, 45)->nullable();
            $table->text(self::USER_AGENT)->nullable();
            $table->longText(self::PAYLOAD);
            $table->unsignedBigInteger(self::LAST_ACTIVITY)->index();
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
