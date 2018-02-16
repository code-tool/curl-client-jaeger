<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;
use Psr\Log\LogLevel;

class HttpConnectTimeLog extends UserLog
{
    /**
     * HttpConnectTimeLog constructor.
     *
     * @param float $startTime
     * @param float $connectOffset
     */
    public function __construct($startTime, $connectOffset)
    {
        parent::__construct(
            'connect',
            LogLevel::DEBUG,
            'Connect time',
            (int)round(1000000 * ($startTime + $connectOffset))
        );
    }
}
