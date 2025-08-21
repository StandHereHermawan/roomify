<?php

namespace App\Traits\Audit;

trait HasBasicAudit
{
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";
    public const DELETED_AT = "deleted_at";
}
