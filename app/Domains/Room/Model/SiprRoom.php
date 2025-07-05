<?php

namespace App\Domains\Room\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRoom extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = 'sipr_rooms';
    public const COLUMN_ID_ITS_NAME = 'id';
    public const COLUMN_ROOM_NAME_ITS_NAME = 'name';
    public const COLUMN_ROOM_CODE_ITS_NAME = 'room_code';
    public const COLUMN_ROOM_HEIGHT_ITS_NAME = 'meter_room_height';
    public const COLUMN_ROOM_FLOOR_WIDE_ITS_NAME = 'meter_squared_floor_wide';

    protected $table = SiprRoom::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    private $limitQuery = 2;
    private $offset = 0;

    protected $fillable = [
        'name',
        'room_code',
        'meter_room_height',
        'meter_squared_floor_wide',
        'created_at',
        'updated_at'
    ];

    public function getId()
    {
        return $this->id;
    }

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
