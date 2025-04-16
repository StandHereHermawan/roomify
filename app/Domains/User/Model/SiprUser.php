<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sipr_users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'username',
        'name',
        'password',
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
