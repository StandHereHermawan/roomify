<?php

use App\Domains\Room\Model\SiprRoomSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiprRoomSession::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->time('room_session_start');
            $table->time('room_session_end');
            $table->softDeletesDatetime();
            
            $table
                ->dateTime('created_at')
                ->nullable(true)
                ->useCurrent();

            $table
                ->dateTime('updated_at')
                ->nullable(true)
                ->useCurrent()
                ->useCurrentOnUpdate();
        });

        DB::transaction(function () {

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(7)->minute(0)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(7)->minute(49)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(7)->minute(50)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(8)->minute(39)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(8)->minute(40)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(9)->minute(29)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(9)->minute(30)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(10)->minute(19)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(10)->minute(20)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(11)->minute(9)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(11)->minute(10)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(12)->minute(0)->second(00),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(12)->minute(50)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(13)->minute(39)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(13)->minute(40)->second(0),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(14)->minute(29)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(14)->minute(30)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(15)->minute(19)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(15)->minute(20)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(16)->minute(9)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(16)->minute(10)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(16)->minute(59)->second(59),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);

            DB::table(SiprRoomSession::TABLE_NAME)->insert([
                "room_session_start" => \Illuminate\Support\Carbon::now()->hour(17)->minute(00)->second(00),
                "room_session_end" => \Illuminate\Support\Carbon::now()->hour(17)->minute(50)->second(00),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiprRoomSession::TABLE_NAME);
    }
};
