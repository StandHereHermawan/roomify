<?php

namespace App\Domains\User\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Audit\HasBasicAudit;
use App\Traits\Relation\HasRelationWithUserModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprSecondaryEmail extends Model
{
    /** 
     * @use HasFactory<\Database\Factories\UserFactory> 
     * @use HasBasicAudit<App\Traits\Audit\HasBasicAudit> 
     * @use HasIdentifier<App\Traits\Attribute\HasIdentifier> 
     */
    use HasFactory,
        HasIdentifier,
        HasRelationWithUserModel,
        HasBasicAudit,
        SoftDeletes;

    public const TABLE_NAME = "sipr_secondary_emails";
    public const EMAIL = "email";
    public const EMAIL_VERIFIED_AT = "email_verified_at";

    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        self::EMAIL,
        self::EMAIL_VERIFIED_AT,
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    public function getEmail()
    {
        return $this->email;
    }

    public function ownedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprUser::class,
            SiprUserHasSecondaryEmail::TABLE_NAME,
            SiprUserHasSecondaryEmail::EMAIL_ID,
            SiprUserHasSecondaryEmail::USER_ID
        );
    }
}
