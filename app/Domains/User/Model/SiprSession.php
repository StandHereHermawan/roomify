<?php

namespace App\Domains\User\Model;

use App\Traits\Attribute\HasIdentifier;
use App\Traits\Relation\HasRelationWithUserModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SiprSession extends Model
{
    /** 
     * @use HasFactory<\Database\Factories\UserFactory> 
     * @use HasIdentifier<App\Traits\Attribute\HasIdentifier> 
     */
    use HasFactory,
        HasRelationWithUserModel,
        HasIdentifier;

    public const TABLE_NAME = "sipr_sessions";
    public const IP_ADDRESS = "ip_address";
    public const USER_AGENT = "user_agent";
    public const PAYLOAD = "payload";
    public const LAST_ACTIVITY = "last_activity";

    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        self::ID,
        self::USER_ID,
        self::IP_ADDRESS,
        self::USER_AGENT,
        self::PAYLOAD,
        self::LAST_ACTIVITY,
    ];

    public function getSession()
    {
        return $this->id;
    }

    public function getLastActivity()
    {
        return $this->last_activity;
    }

    public function ownedByUser(): HasOne
    {
        return $this->hasOne(SiprUser::class, SiprUser::ID, self::USER_ID);
    }
}
