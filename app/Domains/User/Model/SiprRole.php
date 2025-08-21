<?php

namespace App\Domains\User\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Audit\HasBasicAudit;
use App\Traits\Relation\HasRelationWithUserModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprRole extends Model
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

    public const TABLE_NAME = "sipr_roles";
    public const ROLE = "role";
    public const GUEST = "GUEST";
    public const CUSTOMER = "CUSTOMER";
    public const SUPER_ADMIN = "SUPER_ADMIN";

    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        self::ROLE,
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
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
            SiprUserHasRole::ROLE_ID,
            SiprUserHasRole::USER_ID
        );
    }
}
