<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprPhoneNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sipr_phone_number_contacts";
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

    public function getphoneNumber()
    {
        if ($this->phone_number != null) {
            return $this->phone_number;
        } else {
            return null;
        }
    }
}
