<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class SiprUserHasSession extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_user_has_sessions";

    protected $table = SiprUserHasSession::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "user_id",
        "username",
        "session",
        "created_at",
        "expired_at",
        "deleted_at",
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
