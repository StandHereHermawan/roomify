<?php

namespace App\Domains\Room\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Audit\HasBasicAudit;
use App\Traits\Relation\HasRelationWithUserModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoom extends Model
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

    public const TABLE_NAME = 'sipr_rooms';
    public const NAME = 'name';
    public const CODE = 'room_code';
    public const HEIGHT = 'meter_room_height';
    public const FLOOR_WIDE = 'meter_squared_floor_wide';

    protected $table = self::TABLE_NAME;
    protected $primaryKey = self::ID;
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    private $limitQuery = 2;
    private $offset = 0;

    protected $fillable = [
        self::NAME,
        self::CODE,
        self::HEIGHT,
        self::FLOOR_WIDE,
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    public function getName()
    {
        return $this->name;
    }

    public function getRoomCode()
    {
        return $this->room_code;
    }

    public function getRoomHeight()
    {
        return $this->meter_room_height;
    }
}
