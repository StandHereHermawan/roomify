<?php

namespace App\Domains\Room\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Audit\HasBasicAudit;
use App\Traits\Relation\HasRelationWithUserModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomSession extends Model
{
    /**
     * @use HasBasicAudit<App\Traits\Audit\HasBasicAudit> 
     * @use HasIdentifier<App\Traits\Attribute\HasIdentifier> 
     * @use HasRelationWithUserModel<App\Traits\Relation\HasRelationWithUserModel> 
     */
    use HasIdentifier,
        HasRelationWithUserModel,
        HasBasicAudit,
        SoftDeletes;

    public const TABLE_NAME = 'sipr_room_sessions';
    public const SESSION_START = 'room_session_start';
    public const SESSION_END = 'room_session_end';

    protected $table = SiprRoomSession::TABLE_NAME;
    protected $primaryKey = self::ID;
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        SiprRoomSession::SESSION_START,
        SiprRoomSession::SESSION_END,
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
