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

    protected $table = SiprRole::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'role',
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function ownedByUsers(): BelongsToMany {
        return $this->belongsToMany(SiprUser::class, "sipr_users_has_roles", "role_id", "user_id");
    }
}
