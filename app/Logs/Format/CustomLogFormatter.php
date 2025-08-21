<?php

namespace App\Logs\Format;

use Illuminate\Log\Logger;

use Monolog\Level;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\IntrospectionProcessor;

class CustomLogFormatter
{
    const CUSTOM_FORMAT = "[%datetime%] %channel%.%level_name%: %message% [class: %extra.class%] | [function: %extra.function%] | [%context%]\n";
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * Customize the given logger instance.
     */
    public function __invoke(Logger $logger): void
    {
        // added custom processor to manipulate extra.class make the namespace lost.
        $logger->pushProcessor(function ($record) {
            if (isset($record['extra']['class'])) {
                $record['extra']['class'] = class_basename($record['extra']['class']);
            }
            return $record;
        });

        $logger->pushProcessor(new IntrospectionProcessor(
            Level::Debug,
            ['Illuminate\\']
        ));

        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                self::CUSTOM_FORMAT,
                self::DATE_FORMAT,
                true,
                true
            ));
        }
    }
}
