<?php

namespace App\Domains\Schedule\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomSessionReservationRequest extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = "sipr_session_reservation_requests";
    public const COLUMN_ID_ITS_NAME = "id";

    protected $table = SiprRoomSessionReservationRequest::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    private $paginate = 2;

    protected $fillable = [
        SiprRoomSessionReservationRequest::COLUMN_ID_ITS_NAME,
        SiprRoomSessionReservationRequest::CREATED_AT,
        SiprRoomSessionReservationRequest::UPDATED_AT,
        "deleted_at",
    ];
}
