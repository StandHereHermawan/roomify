<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprPhoneNumber extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_phone_numbers";
    public const COLUMN_ID_ITS_NAME = "id";
    public const COLUMN_PHONE_NUMBER_ITS_NAME = "phone_number";

    protected $table = SiprPhoneNumber::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'phone_number',
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function getId()
    {
        if ($this->id != null) {
            return $this->id;
        } else {
            return null;
        }
    }

    public function getphoneNumber()
    {
        if ($this->phone_number != null) {
            return $this->phone_number;
        } else {
            return null;
        }
    }
}
