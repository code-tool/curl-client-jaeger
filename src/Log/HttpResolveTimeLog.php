<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;
use Psr\Log\LogLevel;

class HttpResolveTimeLog extends UserLog
{
    /**
     * HttpResolveTimeLog constructor.
     *
     * @param float $startTime
     * @param float $resolveOffset
     */
    public function __construct($startTime, $resolveOffset)
    {
        parent::__construct(
            'resolve',
            LogLevel::DEBUG,
            'Resolve time',
            (int)round(1000000 * ($startTime + $resolveOffset))
        );
    }
}
