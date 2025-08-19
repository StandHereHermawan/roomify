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
    public const COLUMN_PHONE_NUMBER_ID_ITS_NAME = "phone_number_id";
    public const COLUMN_USER_ID_ITS_NAME = "user_id";

    protected $table = SiprUserHasPhoneNumber::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME,
        SiprUserHasPhoneNumber::COLUMN_USER_ID_ITS_NAME,
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getPhoneNumberId()
    {
        return $this->phone_number_id;
    }
}
