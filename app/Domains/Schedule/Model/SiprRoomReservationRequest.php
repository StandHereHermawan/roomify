<?php

namespace App\Domains\Schedule\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomReservationRequest extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = "sipr_room_reservation_requests";
    public const COLUMN_ID_ITS_NAME = "id";

    protected $table = SiprRoomReservationRequest::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    private $paginate = 2;

    protected $fillable = [
        SiprRoomReservationRequest::COLUMN_ID_ITS_NAME,
        SiprRoomReservationRequest::CREATED_AT,
        SiprRoomReservationRequest::UPDATED_AT,
        "deleted_at",
    ];
}
