<?php

namespace App\Traits\Logs;

use Illuminate\Support\Facades\Log;

trait CustomLogger
{
    protected function logDebugStart(string $method, array $context = []): void
    {
        if ($method === null) {
            $method = "Method not defined.";
        }

        Log::debug("[class: {$this->getClassName()}] | [method: {$method}] Started.", $context);
    }

    protected function logDebugMessage(string $method, string $message, array $context = []): void
    {
        if ($method === null) {
            $method = "Method not defined.";
        }

        Log::debug("$message.", $context);
    }

    protected function logDebugFinish(string $method, array $context = [], float $start_time = null): void
    {
        $message = "[class: {$this->getClassName()}] | [method::{$method}] Finished.";

        if ($start_time !== null) {
            $duration = round((microtime(true) - $start_time) * 1000, 2);
            $message = "[class: {$this->getClassName()}] | [method::{$method}] Finished in {$duration} ms.";
        }

        Log::debug($message, $context);
    }

    protected function logInfoStart(string $method, array $context = []): void
    {
        if ($method === null) {
            $method = "Method not defined.";
        }

        Log::info("[class: {$this->getClassName()}] | [method: {$method}] Started.", $context);
    }

    protected function logInfoFinish(string $method, array $context = [], float $startTime = null): void
    {
        $message = "[class: {$this->getClassName()}] | [method: {$method}] Finished";
        if ($startTime !== null) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            $message = "[class: {$this->getClassName()}] | [method: {$method}] Finished in {$duration} ms";
        }

        Log::info($message, $context);
    }

    protected function logInfoMessage(string $message, array $context = []): void
    {
        Log::info($message, $context);
    }

    private function getClassName(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
