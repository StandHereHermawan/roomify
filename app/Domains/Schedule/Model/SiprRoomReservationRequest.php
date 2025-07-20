<?php

namespace App\Domains\Schedule\Model;

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\User\Model\SiprUser;

class SiprRoomReservationRequest extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = "sipr_room_reservation_requests";
    public const COLUMN_ID_ITS_NAME = "id";
    public const COLUMN_USER_ID_ITS_NAME = "user_id";
    public const COLUMN_ROOM_ID_ITS_NAME = "room_id";
    public const COLUMN_STATUS_ITS_NAME = "status";
    public const COLUMN_DETERMINED_AT_ITS_NAME = "determined_at";
    public const COLUMN_RESERVATION_DATE_ITS_NAME = "reservation_date";

    protected $table = SiprRoomReservationRequest::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        SiprRoomReservationRequest::COLUMN_ID_ITS_NAME,
        SiprRoomReservationRequest::COLUMN_USER_ID_ITS_NAME,
        SiprRoomReservationRequest::COLUMN_ROOM_ID_ITS_NAME,
        SiprRoomReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME,
        SiprRoomReservationRequest::COLUMN_DETERMINED_AT_ITS_NAME,
        SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME,
        SiprRoomReservationRequest::CREATED_AT,
        SiprRoomReservationRequest::UPDATED_AT,
        "deleted_at",
    ];

    public function getId()
    {
        return $this->id;
    }

    public function userRequest(): HasOne
    {
        return $this->hasOne(
            SiprUser::class,
            "id",
            SiprRoomReservationRequest::COLUMN_USER_ID_ITS_NAME,
        );
    }

    public function roomReserved(): HasOne
    {
        return $this->hasOne(
            SiprRoom::class,
            "id",
            SiprRoomReservationRequest::COLUMN_ROOM_ID_ITS_NAME,
        );
    }

    public function sessionBorrowed(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprRoomSession::class,
            SiprRoomSessionReservationRequest::class,
            "room_reservation_id",
            "room_session_id"
        );
    }
}
