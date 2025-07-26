<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class SiprSession extends Model
{
    use HasFactory;

    public const TABLE_NAME = "sipr_sessions";
    public const COLUMN_ID_ITS_NAME = "id";
    public const COLUMN_USER_ID_ITS_NAME = "user_id";
    public const COLUMN_IP_ADDRESS_ITS_NAME = "ip_address";
    public const COLUMN_USER_AGENT_ITS_NAME = "user_agent";
    public const COLUMN_PAYLOAD_ITS_NAME = "payload";
    public const COLUMN_LAST_ACTIVITY_ITS_NAME = "last_activity";

    protected $table = SiprSession::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        SiprSession::COLUMN_ID_ITS_NAME,
        SiprSession::COLUMN_USER_ID_ITS_NAME,
        SiprSession::COLUMN_IP_ADDRESS_ITS_NAME,
        SiprSession::COLUMN_USER_AGENT_ITS_NAME,
        SiprSession::COLUMN_PAYLOAD_ITS_NAME,
        SiprSession::COLUMN_LAST_ACTIVITY_ITS_NAME,
    ];

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

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
        return $this->hasOne(SiprUser::class, "id", "user_id");
    }
}
