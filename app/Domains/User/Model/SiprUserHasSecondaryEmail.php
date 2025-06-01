<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUserHasSecondaryEmail extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_user_has_emails";

    protected $table = SiprUserHasSecondaryEmail::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    public function getUserId()
    {
        if ($this->user_id != null) {
            return $this->user_id;
        } else {
            return null;
        }
    }

    public function getEmailId()
    {
        if ($this->email_id != null) {
            return $this->email_id;
        } else {
            return null;
        }
    }

    protected $fillable = [
        'user_id',
        'email_id',
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
