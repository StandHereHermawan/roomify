<?php

use App\Domains\User\Model\SiprSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprSession::TABLE_NAME, function (Blueprint $table) {
            $table->string(SiprSession::COLUMN_ID_ITS_NAME)->primary();
            $table->foreignId(SiprSession::COLUMN_USER_ID_ITS_NAME)->nullable()->index();
            $table->string(SiprSession::COLUMN_IP_ADDRESS_ITS_NAME, 45)->nullable();
            $table->text(SiprSession::COLUMN_USER_AGENT_ITS_NAME)->nullable();
            $table->longText(SiprSession::COLUMN_PAYLOAD_ITS_NAME);
            $table->integer(SiprSession::COLUMN_LAST_ACTIVITY_ITS_NAME)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprSession::TABLE_NAME);
    }
};
