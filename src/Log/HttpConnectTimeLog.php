<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

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
            'debug',
            (string)(1000000 * ($startTime + $connectOffset)),
            (int)round(1000000 * ($startTime + $connectOffset))
        );
    }
}
