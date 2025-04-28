<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUserHasRole extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sipr_user_has_roles";
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
