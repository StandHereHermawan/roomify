<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUserHasRole extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_user_has_roles";
    public const COLUMN_USER_ID_ITS_NAME = "user_id";
    public const COLUMN_ROLE_ID_ITS_NAME = "role_id";

    protected $table = SiprUserHasRole::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    public function getSession() {
        return $this->session;
    }

    protected $fillable = [
        'user_id',
        'role_id',
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
