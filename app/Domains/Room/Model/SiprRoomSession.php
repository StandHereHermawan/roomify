<?php

namespace App\Domains\Room\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomSession extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = 'sipr_room_sessions';
    public const ID = 'id';
    public const SESSION_START = 'room_session_start';
    public const SESSION_END = 'room_session_end';

    protected $table = SiprRoomSession::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        SiprRoomSession::SESSION_START,
        SiprRoomSession::SESSION_END,
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getRoomSessionStart()
    {
        return $this->room_session_start;
    }

    public function getRoomSessionEnd()
    {
        return $this->room_session_end;
    }
}
