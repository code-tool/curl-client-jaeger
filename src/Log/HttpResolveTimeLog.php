<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResolveTimeLog extends UserLog
{
    /**
     * HttpResolveTimeLog constructor.
     *
     * @param int $startTime
     * @param int $resolveOffset
     */
    public function __construct($startTime, $resolveOffset)
    {
        parent::__construct(
            'resolve',
            'debug',
            (string)(1000 * ($startTime + $resolveOffset)),
            1000 * ($startTime + $resolveOffset)
        );
    }
}
