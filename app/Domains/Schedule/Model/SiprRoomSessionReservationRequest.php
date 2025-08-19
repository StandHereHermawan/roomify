<?php

namespace App\Domains\Schedule\Model;

use App\Domains\Room\Model\SiprRoomSession;
use \App\Domains\User\Model\SiprUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomSessionReservationRequest extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = "sipr_session_reservation_requests";
    public const COLUMN_ID_ITS_NAME = "id";
    public const COLUMN_USER_ID_ITS_NAME = "user_id";
    public const COLUMN_ROOM_RESERVATION_ID_ITS_NAME = "room_reservation_id";
    public const COLUMN_ROOM_SESSION_ID_ITS_NAME = "room_session_id";

    protected $table = SiprRoomSessionReservationRequest::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        SiprRoomSessionReservationRequest::COLUMN_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::COLUMN_USER_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::CREATED_AT,
        SiprRoomSessionReservationRequest::UPDATED_AT,
        "deleted_at",
    ];

    public function getId()
    {
        return $this->id;
    }

    public function userRequest(): BelongsTo
    {
        return $this->belongsTo(
            SiprUser::class,
            SiprRoomSessionReservationRequest::COLUMN_USER_ID_ITS_NAME,
            SiprUser::ID,
        );
    }

    public function roomSession(): BelongsTo
    {
        return $this->belongsTo(
            SiprRoomSession::class,
            SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME,
            SiprRoomSession::ID,
        );
    }

    public function roomReservation(): BelongsTo
    {
        return $this->belongsTo(
            SiprRoomReservationRequest::class,
            SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME,
            SiprRoomReservationRequest::COLUMN_ID_ITS_NAME
        );
    }
}
