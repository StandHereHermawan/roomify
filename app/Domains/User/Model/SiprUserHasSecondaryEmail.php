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
    public const COLUMN_USER_ID_ITS_NAME = "user_id";
    public const COLUMN_EMAIL_ID_ITS_NAME = "email_id";

    protected $table = SiprUserHasSecondaryEmail::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'email_id',
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getEmailId()
    {
        return $this->email_id;
    }
}
