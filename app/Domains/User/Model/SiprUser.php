<?php

namespace App\Domains\User\Model;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUser extends Model implements Authenticatable
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = "sipr_users";
    public const COLUMN_ID_ITS_NAME = "id";
    public const COLUMN_USERNAME_ITS_NAME = "username";
    public const COLUMN_NAME_ITS_NAME = "name";
    public const COLUMN_PASSWORD_ITS_NAME = "password";

    protected $table = SiprUser::TABLE_NAME;
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    private $limit_pagination = 2;

    protected $fillable = [
        SiprUser::COLUMN_ID_ITS_NAME,
        SiprUser::COLUMN_USERNAME_ITS_NAME,
        SiprUser::COLUMN_NAME_ITS_NAME,
        SiprUser::COLUMN_PASSWORD_ITS_NAME,
        SiprUser::CREATED_AT,
        SiprUser::UPDATED_AT,
        "deleted_at",
    ];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getId();
    }

    /**
     * Get the name of the password attribute for the user.
     *
     * @return string
     */
    public function getAuthPasswordName()
    {
        return SiprUser::COLUMN_PASSWORD_ITS_NAME;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getPassword();
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->getRememberToken();
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        return;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getId()
    {
        if ($this->id != null) {
            # code...
            return $this->id;
        } else {
            return null;
        }
    }

    public function getUsername()
    {
        if ($this->username != null) {
            # code...
            return $this->username;
        } else {
            return null;
        }
    }

    public function getName()
    {
        if ($this->name != null) {
            # code...
            return $this->name;
        } else {
            return null;
        }
    }

    public function getPassword()
    {
        if ($this->password != null) {
            # code...
            return $this->password;
        } else {
            return null;
        }
    }

    public function hasRoles(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprRole::class,
            SiprUserHasRole::TABLE_NAME,
            "user_id",
            "role_id"
        );
    }

    public function hasPhoneNumbers(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprPhoneNumber::class,
            "sipr_user_has_phone_numbers",
            "user_id",
            "phone_number_id"
        );
    }

    public function hasEmails(): BelongsToMany
    {
        return $this->belongsToMany(
            SiprSecondaryEmail::class,
            "sipr_user_has_emails",
            "user_id",
            "email_id"
        );
    }

    public function hasSession(): HasOne
    {
        return $this->hasOne(
            SiprSession::class,
            "user_id",
            "id"
        );
    }
}
