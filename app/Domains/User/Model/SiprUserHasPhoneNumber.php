<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUserHasPhoneNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sipr_user_has_phone_numbers";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'phone_number_id',
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function getIdUser()
    {
        if ($this->user_id != null) {
            return $this->user_id;
        } else {
            return null;
        }
    }

    public function getIdPhoneNumber()
    {
        if ($this->IdPhoneNumber != null) {
            return $this->IdPhoneNumber;
        } else {
            return null;
        }
    }
}
