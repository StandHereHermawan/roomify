<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprPhoneNumber extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_phone_numbers";
    public const COLUMN_ID_ITS_NAME = "id";
    public const PHONE_NUMBER = "phone_number";

    protected $table = SiprPhoneNumber::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        SiprPhoneNumber::COLUMN_ID_ITS_NAME,
        SiprPhoneNumber::PHONE_NUMBER,
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function ownedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprUser::class,
            SiprUserHasPhoneNumber::TABLE_NAME,
            SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME,
            SiprUserHasPhoneNumber::COLUMN_USER_ID_ITS_NAME
        );
    }
}
