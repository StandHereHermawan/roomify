<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiprEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sipr_emails";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'email',
        'email_verified_at',
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
