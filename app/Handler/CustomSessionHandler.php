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
        Log::debug("class: CustomSessionHandler | method: __construct | called.");
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
        Log::debug("class: CustomSessionHandler | method: userId | called.");
        $user_id = $this->container->make(Guard::class)->id();
        // Log::debug("class: CustomSessionHandler | method: userId | user_id: {user_id}.", ["user_id" => $user_id]);

        return $user_id;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function gc($lifetime): int
    {
        Log::debug("class: CustomSessionHandler | method: gc | called.");
        return $this->getQuery()->where('last_activity', '<=', $this->currentTime() - $lifetime)->delete();
    }

    /**
     * Get the user agent for the current request.
     *
     * @return string
     */
    protected function userAgent()
    {
        Log::debug("class: CustomSessionHandler | method: userAgent | called.");
        return substr((string) $this->container->make('request')->header('User-Agent'), 0, 500);
    }

    /**
     * Get the default payload for the session.
     *
     * @param  string  $data
     * @return array
     */
    protected function getDefaultPayload($data)
    {
        Log::debug("class: CustomSessionHandler | method: getDefaultPayload | called.");

        $payload = [
            'payload' => base64_encode($data),
            'last_activity' => $this->currentTime(),
        ];

        if (! $this->container) {
            return $payload;
        }

        return tap($payload, function (&$payload) {
            $this->addUserInformation($payload)
                ->addRequestInformation($payload);
        });
    }

    /**
     * {@inheritdoc}
     *
     * @return string|false
     */
    public function read($sessionId): string|false
    {
        Log::debug("class: CustomSessionHandler | method: read | called.");
        //Log::debug("class: CustomSessionHandler | method: read | session_id: {sessionId}.",["sessionId" => $sessionId]);

        $session = (object) $this->getQuery()->find($sessionId);

        if ($this->expired($session)) {
            $this->exists = true;

            return '';
        }

        if (isset($session->payload)) {
            $this->exists = true;

            return base64_decode($session->payload);
        }

        return '';
    }

    /**
     * Determine if the session is expired.
     *
     * @param  \stdClass  $session
     * @return bool
     */
    protected function expired($session)
    {
        Log::debug("class: CustomSessionHandler | method: expired | called.");
        
        return isset($session->last_activity) &&
            $session->last_activity < \Illuminate\Support\Carbon::now()->subMinutes($this->minutes)->getTimestamp();
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function write($sessionId, $data): bool
    {
        Log::debug("class: CustomSessionHandler | method: write | called.");

        $payload = $this->getDefaultPayload($data);

        if (! $this->exists) {
            $this->read($sessionId);
        }

        if ($this->exists) {
            $this->performUpdate($sessionId, $payload);
        } else {
            $this->performInsert($sessionId, $payload);
        }

        return $this->exists = true;
    }

    /**
     * Perform an insert operation on the session ID.
     *
     * @param  string  $sessionId
     * @param  array<string, mixed>  $payload
     * @return bool|null
     */
    protected function performInsert($sessionId, $payload)
    {
        Log::debug("class: CustomSessionHandler | method: performInsert | called.");

        try {
            return $this->getQuery()->insert(\Illuminate\Support\Arr::set($payload, 'id', $sessionId));
        } catch (QueryException) {
            $this->performUpdate($sessionId, $payload);
        }
    }

    /**
     * Perform an update operation on the session ID.
     *
     * @param  string  $sessionId
     * @param  array<string, mixed>  $payload
     * @return int
     */
    protected function performUpdate($sessionId, $payload)
    {
        Log::debug("class: CustomSessionHandler | method: performUpdate | called.");
        return $this->getQuery()->where('id', $sessionId)->update($payload);
    }

    /**
     * Get a fresh query builder instance for the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getQuery()
    {
        Log::debug("class: CustomSessionHandler | method: getQuery | called.");
        return $this->connection->table($this->table)->useWritePdo();
    }

        /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function open($savePath, $sessionName): bool
    {
        Log::debug("class: CustomSessionHandler | method: open | called.");
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function close(): bool
    {
        Log::debug("class: CustomSessionHandler | method: close | called.");
        return true;
    }

    /**
     * Add the user information to the session payload.
     *
     * @param  array  $payload
     * @return $this
     */
    protected function addUserInformation(&$payload)
    {
        Log::debug("class: CustomSessionHandler | method: addUserInformation | called.");
        if ($this->container->bound(Guard::class)) {
            $payload['user_id'] = $this->userId();
        }

        return $this;
    }

    /**
     * Add the request information to the session payload.
     *
     * @param  array  $payload
     * @return $this
     */
    protected function addRequestInformation(&$payload)
    {
        Log::debug("class: CustomSessionHandler | method: addRequestInformation | called.");
        if ($this->container->bound('request')) {
            $payload = array_merge($payload, [
                'ip_address' => $this->ipAddress(),
                'user_agent' => $this->userAgent(),
            ]);
        }

        return $this;
    }

    /**
     * Get the IP address for the current request.
     *
     * @return string|null
     */
    protected function ipAddress()
    {
        Log::debug("class: CustomSessionHandler | method: ipAddress | called.");
        return $this->container->make('request')->ip();
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function destroy($sessionId): bool
    {
        Log::debug("class: CustomSessionHandler | method: destroy | called.");
        $this->getQuery()->where('id', $sessionId)->delete();

        return true;
    }

    /**
     * Set the application instance used by the handler.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $container
     * @return $this
     */
    public function setContainer($container)
    {
        Log::debug("class: CustomSessionHandler | method: setContainer | called.");
        $this->container = $container;

        return $this;
    }

    /**
     * Set the existence state for the session.
     *
     * @param  bool  $value
     * @return $this
     */
    public function setExists($value)
    {
        Log::debug("class: CustomSessionHandler | method: setExists | called.");
        $this->exists = $value;

        return $this;
    }
}
