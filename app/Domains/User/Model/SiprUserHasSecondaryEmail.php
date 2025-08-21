<?php

namespace App\Domains\User\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Audit\HasBasicAudit;
use App\Traits\Relation\HasRelationWithUserModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUserHasSecondaryEmail extends Model
{
    /**
     * @use HasBasicAudit<App\Traits\Audit\HasBasicAudit> 
     * @use HasIdentifier<App\Traits\Attribute\HasIdentifier> 
     * @use HasRelationWithUserModel<App\Traits\Relation\HasRelationWithUserModel> 
     */
    use HasFactory,
        HasIdentifier,
        HasRelationWithUserModel,
        HasBasicAudit,
        SoftDeletes;

    public const TABLE_NAME = "sipr_user_has_emails";
    public const EMAIL_ID = "email_id";

    protected $table = self::TABLE_NAME;
    protected $primaryKey = self::ID;
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        self::EMAIL_ID,
        self::USER_ID,
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    public function getEmailId()
    {
        return $this->email_id;
    }
}
