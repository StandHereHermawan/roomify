<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUserHasPhoneNumber extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_user_has_phone_numbers";

    protected $table = SiprUserHasPhoneNumber::TABLE_NAME;
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

    public function getUserId()
    {
        return $this->getIdUser();
    }

    public function getIdPhoneNumber()
    {
        if ($this->phone_number_id != null) {
            return $this->phone_number_id;
        } else {
            return null;
        }
    }
}
