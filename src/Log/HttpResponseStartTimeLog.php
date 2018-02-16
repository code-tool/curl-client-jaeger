<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;
use Psr\Log\LogLevel;

class HttpResponseStartTimeLog extends UserLog
{
    /**
     * HttpResponseStartTimeLog constructor.
     *
     * @param float $startTime
     * @param float $startOffset
     */
    public function __construct($startTime, $startOffset)
    {
        parent::__construct(
            'response.start',
            LogLevel::DEBUG,
            'First byte received',
            (int)round(1000000 * ($startTime + $startOffset))
        );
    }
}
