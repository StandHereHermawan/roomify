<?php

namespace App\Domains\Room\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomSession extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = 'sipr_room_sessions';
    public const COLUMN_ID_NAME = 'id';
    public const COLUMN_ROOM_SESSION_START_NAME = 'room_session_start';
    public const COLUMN_ROOM_SESSION_END_NAME = 'room_session_end';

    protected $table = SiprRoomSession::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        SiprRoomSession::COLUMN_ROOM_SESSION_START_NAME,
        SiprRoomSession::COLUMN_ROOM_SESSION_END_NAME,
    ];

    public function getRoomSessionStart()
    {
        return $this->room_session_start;
    }

    public function getRoomSessionEnd()
    {
        return $this->room_session_end;
    }
}
