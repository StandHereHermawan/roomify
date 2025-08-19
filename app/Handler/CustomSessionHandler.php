<?php

namespace App\Handler;

use App\Traits\Logs\CustomLogger;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Auth\Guard;

use Illuminate\Database\ConnectionInterface;

use Illuminate\Session\DatabaseSessionHandler;

use Illuminate\Support\Facades\Log;

class CustomSessionHandler extends DatabaseSessionHandler
{
    use CustomLogger;

    public function __construct(
        ConnectionInterface $connection,
        $table,
        $minutes,
        ?Container $container = null
    ) {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        $user_id = $this->container->make(Guard::class)->id();
        // Log::debug("class: CustomSessionHandler | method: userId | user_id: {user_id}.", ["user_id" => $user_id]);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return $user_id;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function gc($lifetime): int
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return $this->getQuery()->where('last_activity', '<=', $this->currentTime() - $lifetime)->delete();
    }

    /**
     * Get the user agent for the current request.
     *
     * @return string
     */
    protected function userAgent()
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        $payload = [
            'payload' => base64_encode($data),
            'last_activity' => $this->currentTime(),
        ];
        
        if (! $this->container) {
            // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
            return $payload;
        }
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        //Log::debug("class: CustomSessionHandler | method: read | session_id: {sessionId}.",["sessionId" => $sessionId]);
        
        $session = (object) $this->getQuery()->find($sessionId);
        
        if ($this->expired($session)) {
            $this->exists = true;

            // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
            return '';
        }

        if (isset($session->payload)) {
            $this->exists = true;
            
            // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
            return base64_decode($session->payload);
        }
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        $payload = $this->getDefaultPayload($data);
        
        if (! $this->exists) {
            $this->read($sessionId);
        }
        
        if ($this->exists) {
            $this->performUpdate($sessionId, $payload);
        } else {
            $this->performInsert($sessionId, $payload);
        }
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        try {
            // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
            return $this->getQuery()->insert(\Illuminate\Support\Arr::set($payload, 'id', $sessionId));
        } catch (QueryException) {
            $this->performUpdate($sessionId, $payload);
            // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return $this->getQuery()->where('id', $sessionId)->update($payload);
    }

    /**
     * Get a fresh query builder instance for the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getQuery()
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return $this->connection->table($this->table)->useWritePdo();
    }

        /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function open($savePath, $sessionName): bool
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function close(): bool
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        if ($this->container->bound(Guard::class)) {
            $payload['user_id'] = $this->userId();
        }
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        if ($this->container->bound('request')) {
            $payload = array_merge($payload, [
                'ip_address' => $this->ipAddress(),
                'user_agent' => $this->userAgent(),
            ]);
        }
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return $this;
    }

    /**
     * Get the IP address for the current request.
     *
     * @return string|null
     */
    protected function ipAddress()
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return $this->container->make('request')->ip();
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function destroy($sessionId): bool
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        $this->container = $container;
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
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
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        $this->exists = $value;
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return $this;
    }
}
