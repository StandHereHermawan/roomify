<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRole extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_roles";
    public const ID = "id";
    public const ROLE = "role";
    public const GUEST = "GUEST";
    public const CUSTOMER = "CUSTOMER";
    public const SUPER_ADMIN = "SUPER_ADMIN";

    protected $table = SiprRole::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        SiprRole::ROLE,
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function ownedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprUser::class,
            SiprUserHasRole::TABLE_NAME,
            SiprUserHasRole::COLUMN_ROLE_ID_ITS_NAME,
            SiprUserHasRole::COLUMN_USER_ID_ITS_NAME
        );
    }
}
