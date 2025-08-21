<?php

namespace App\Domains\User\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Audit\HasBasicAudit;
use App\Traits\Relation\HasRelationWithUserModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprPhoneNumber extends Model
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

    public const TABLE_NAME = "sipr_phone_numbers";
    public const PHONE_NUMBER = "phone_number";

    protected $table = SiprPhoneNumber::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        self::PHONE_NUMBER,
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function ownedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprUser::class,
            SiprUserHasPhoneNumber::TABLE_NAME,
            SiprUserHasPhoneNumber::PHONE_NUMBER_ID,
            SiprUserHasPhoneNumber::USER_ID
        );
    }
}
