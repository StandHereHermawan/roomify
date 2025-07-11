<?php

namespace App\Domains\Schedule\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomSessionReservationRequest extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = "sipr_session_reservation_requests";
    public const COLUMN_ID_ITS_NAME = "id";
    public const COLUMN_USER_ID_ITS_NAME = "user_id";
    public const COLUMN_ROOM_RESERVATION_ID_ITS_NAME = "room_reservation_id";
    public const COLUMN_ROOM_SESSION_ID_ITS_NAME = "room_session_id";
    public const COLUMN_RESERVATION_DATE_ITS_NAME = "reservation_date";

    protected $table = SiprRoomSessionReservationRequest::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    private $paginate = 2;

    protected $fillable = [
        SiprRoomSessionReservationRequest::COLUMN_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::COLUMN_USER_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME,
        SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::CREATED_AT,
        SiprRoomSessionReservationRequest::UPDATED_AT,
        "deleted_at",
    ];
}
