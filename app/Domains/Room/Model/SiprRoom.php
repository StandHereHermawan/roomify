<?php

namespace App\Domains\Room\Model;

use Illuminate\Database\Eloquent\Model;

class SiprRoom extends Model
{
    public const TABLE_NAME = 'sipr_rooms';

    protected $table = SiprRoom::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;
    private $limitQuery = 2;
    private $offset = 0;

    protected $fillable = [
        
    ];
}
