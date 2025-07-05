<?php

namespace App\Handler;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Session\DatabaseSessionHandler;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Log;
use ReflectionClass;

class CustomSessionHandler extends DatabaseSessionHandler
{
    public function __construct(
        ConnectionInterface $connection,
        $table,
        $minutes,
        ?Container $container = null
    ) {
        parent::__construct(
            $this->connection = $connection,
            $this->table = $table,
            $this->minutes = $minutes,
            $this->container = $container,
        );
    }

    /**
     * Get the currently authenticated user's ID.
     *
     * @return mixed
     */
    protected function userId()
    {
        $user_id = $this->container->make(Guard::class)->id();
        Log::debug("", [
            "class_name" => CustomSessionHandler::class,
            "method_name" => "userId",
            "user_id" => $user_id,
        ]);
        return $user_id;
    }
}
