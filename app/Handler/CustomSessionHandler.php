<?php

namespace App\Handler;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Auth\Guard;

use Illuminate\Database\ConnectionInterface;

use Illuminate\Session\DatabaseSessionHandler;

use Illuminate\Support\Facades\Log;

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

        Log::debug("class: CustomSessionHandler | method: __construct | called.");
    }

    /**
     * Get the currently authenticated user's ID.
     *
     * @return mixed
     */
    protected function userId()
    {
        Log::debug("class: CustomSessionHandler | method: userId | called.");
        $user_id = $this->container->make(Guard::class)->id();
        Log::debug("class: CustomSessionHandler | method: userId | user_id: {user_id}.", [
            "user_id" => $user_id,
        ]);

        return $user_id;
    }
}
