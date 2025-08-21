<?php

namespace App\Traits\Relation;

trait HasRelationWithUserModel
{
    public const USER_ID = "user_id";

    public function getUserId()
    {
        return $this->user_id;
    }
}
