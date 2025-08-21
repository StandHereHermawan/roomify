<?php

namespace App\Domains\Schedule\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Audit\HasBasicAudit;
use App\Traits\Relation\HasRelationWithUserModel;

use App\Domains\Room\Model\SiprRoomSession;
use \App\Domains\User\Model\SiprUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomSessionReservationRequest extends Model
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

    public const TABLE_NAME = "sipr_session_reservation_requests";
    public const ROOM_RESERVATION_ID = "room_reservation_id";
    public const ROOM_SESSION_ID = "room_session_id";
    public const RESERVATION_DATE = "reservation_date";

    protected $table = self::TABLE_NAME;
    protected $primaryKey = self::ID;
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        self::ROOM_RESERVATION_ID,
        self::RESERVATION_DATE,
        self::ROOM_SESSION_ID,
        self::USER_ID,
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    public function userRequest(): BelongsTo
    {
        return $this->belongsTo(
            SiprUser::class,
            SiprRoomSessionReservationRequest::USER_ID,
            SiprUser::ID,
        );
    }

    public function roomSession(): BelongsTo
    {
        return $this->belongsTo(
            SiprRoomSession::class,
            SiprRoomSessionReservationRequest::ROOM_SESSION_ID,
            SiprRoomSession::ID,
        );
    }

    public function roomReservation(): BelongsTo
    {
        return $this->belongsTo(
            SiprRoomReservationRequest::class,
            SiprRoomSessionReservationRequest::ROOM_RESERVATION_ID,
            SiprRoomReservationRequest::ID
        );
    }
}
