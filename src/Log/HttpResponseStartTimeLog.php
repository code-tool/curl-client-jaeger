<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

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
            'debug',
            'First byte received',
            (int)round(1000000 * ($startTime + $startOffset))
        );
    }
}
