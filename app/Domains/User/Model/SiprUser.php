<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sipr_users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    private $limitQuery = 2;

    protected $fillable = [
        'username',
        'name',
        'password',
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function getId()
    {
        if ($this != null) {
            # code...
            return $this->id;
        } else {
            return null;
        }
    }

    public function getUsername()
    {
        if ($this != null) {
            # code...
            return $this->username;
        } else {
            return null;
        }
    }

    public function getName()
    {
        if ($this != null) {
            # code...
            return $this->name;
        } else {
            return null;
        }
    }

    public function getPassword()
    {
        if ($this != null) {
            # code...
            return $this->password;
        } else {
            return null;
        }
    }

    public function getRoles(int $limit = 2)
    {
        $this->limitQuery = $limit;
        if ($this != null) {
            # code...
            return $this->hasRoles;
        } else {
            return null;
        }
    }

    public function getEmails(int $limit = 2)
    {
        $this->limitQuery = $limit;
        if ($this->hasEmails != null) {
            # code...
            return $this->hasEmails;
        } else {
            return null;
        }
    }

    public function getPhoneNumbers(int $limit = 2)
    {
        $this->limitQuery = $limit;

        if ($this->hasPhoneNumbers != null) {
            # code...
            return $this->hasPhoneNumbers;
        } else {
            return null;
        }
    }

    public function getSession()
    {
        if ($this->hasSession != null) {
            # code...
            return $this->hasSession;
        } else {
            return null;
        }
    }

    public function hasRoles(): BelongsToMany
    {
        $limit = $this->limitQuery;
        return $this
            ->belongsToMany(SiprRole::class, "sipr_user_has_roles", "user_id", "role_id")
            ->limit($limit);
    }

    public function hasPhoneNumbers(): BelongsToMany
    {
        $limit = $this->limitQuery;
        return $this
            ->belongsToMany(SiprPhoneNumber::class, "sipr_user_has_phone_numbers", "user_id", "phone_number_id")
            ->limit($limit);
    }

    public function hasEmails(): BelongsToMany
    {
        $limit = $this->limitQuery;
        return $this
            ->belongsToMany(SiprEmail::class, "sipr_user_has_emails", "user_id", "email_id")
            ->limit($limit);
    }

    public function hasSession(): HasOne
    {
        return $this
            ->hasOne(SiprUserHasSession::class, "user_id", "id");
    }
}
