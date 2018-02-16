<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpConnectTimeLog extends UserLog
{
    /**
     * HttpConnectTimeLog constructor.
     *
     * @param int $startTime
     * @param int $connectOffset
     */
    public function __construct($startTime, $connectOffset)
    {
        parent::__construct(
            'connect',
            'debug',
            (string)(1000 * ($startTime + $connectOffset)),
            1000 * ($startTime + $connectOffset)
        );
    }
}
