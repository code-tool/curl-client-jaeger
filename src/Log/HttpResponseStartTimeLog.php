<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResponseStartTimeLog extends UserLog
{
    /**
     * HttpResponseStartTimeLog constructor.
     *
     * @param int $startTime
     * @param int $startOffset
     */
    public function __construct($startTime, $startOffset)
    {
        parent::__construct(
            'response.start',
            'debug',
            (string)(1000 * ($startTime + $startOffset)),
            1000 * ($startTime + $startOffset)
        );
    }
}
