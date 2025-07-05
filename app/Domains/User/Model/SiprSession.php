<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function getIdUser()
    {
        if ($this->user_id != null) {
            return $this->user_id;
        } else {
            return null;
        }
    }

    public function getUsername()
    {
        if ($this->username != null) {
            return $this->username;
        } else {
            return null;
        }
    }

    public function getSession()
    {
        if ($this->session != null) {
            return $this->session;
        } else {
            return null;
        }
    }

    public function getExpiredAt()
    {
        if ($this->expired_at != null) {
            return $this->expired_at;
        } else {
            return null;
        }
    }

    public function getExpiredAtMillis()
    {
        return Carbon::createFromTimeString($this->expired_at)->valueOf();
    }

    public function getDurationLeftSessionExpired()
    {
        return $this->getExpiredAtMillis() - Carbon::now()->valueOf();
    }

    function getIdUserAndUsernameAndSessionAndExpiredAtAsArray()
    {
        return [
            "idUser" => $this->getIdUser(),
            "username" => $this->getUsername(),
            "session" => $this->getSession(),
            "expired_at" => $this->getExpiredAt(),
        ];
    }

    public function getSessionOwner()
    {
        return $this->ownedByUser;
    }

    public function ownedByUser(): BelongsTo
    {
        return $this
            ->belongsTo(SiprUser::class, "user_id", "id");
    }
}
