<?php

namespace App\Domains\Schedule\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Audit\HasBasicAudit;
use App\Traits\Relation\HasRelationWithUserModel;

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;
use App\Domains\User\Model\SiprUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoomReservationRequest extends Model
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

    public const TABLE_NAME = "sipr_room_reservation_requests";
    public const ROOM_ID = "room_id";
    public const STATUS = "status";
    public const DETERMINED_AT = "determined_at";
    public const RESERVATION_DATE = "reservation_date";

    protected $table = self::TABLE_NAME;
    protected $primaryKey = self::ID;
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        self::ROOM_ID,
        self::RESERVATION_DATE,
        self::DETERMINED_AT,
        self::STATUS,
        self::ID,
        self::USER_ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    public function userRequest(): HasOne
    {
        return $this->hasOne(
            SiprUser::class,
            SiprUser::ID,
            SiprRoomReservationRequest::USER_ID,
        );
    }

    public function roomReserved(): HasOne
    {
        return $this->hasOne(
            SiprRoom::class,
            SiprRoom::ID,
            SiprRoomReservationRequest::ROOM_ID,
        );
    }

    public function sessionBorrowed(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprRoomSession::class,
            SiprRoomSessionReservationRequest::class,
            SiprRoomSessionReservationRequest::ROOM_RESERVATION_ID,
            SiprRoomSessionReservationRequest::ROOM_SESSION_ID
        );
    }
}
