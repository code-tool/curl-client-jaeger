<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;
use Psr\Log\LogLevel;

class HttpResponseFinishTimeLog extends UserLog
{
    /**
     * HttpResponseFinishTimeLog constructor.
     *
     * @param float $startTime
     * @param float $finishOffset
     */
    public function __construct($startTime, $finishOffset)
    {
        parent::__construct(
            'response.finish',
            LogLevel::DEBUG,
            'Response received',
            (int)round(1000000 * ($startTime + $finishOffset))
        );
    }
}
