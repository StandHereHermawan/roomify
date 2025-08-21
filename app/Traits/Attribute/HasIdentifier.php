<?php

namespace App\Traits\Attribute;

trait HasIdentifier
{
    public const ID = "id";

    public function getId()
    {
        return $this->id;
    }
}
