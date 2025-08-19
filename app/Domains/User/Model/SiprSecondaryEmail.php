<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprSecondaryEmail extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_secondary_emails";
    public const COLUMN_ID_ITS_NAME = "id";
    public const EMAIL = "email";

    protected $table = SiprSecondaryEmail::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'email',
        'email_verified_at',
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function ownedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprUser::class,
            SiprUserHasSecondaryEmail::TABLE_NAME,
            SiprUserHasSecondaryEmail::COLUMN_EMAIL_ID_ITS_NAME,
            SiprUserHasSecondaryEmail::COLUMN_USER_ID_ITS_NAME
        );
    }
}
