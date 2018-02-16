<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

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
            'debug',
            (string)(1000000 * ($startTime + $finishOffset)),
            (int)round(1000000 * ($startTime + $finishOffset))
        );
    }
}
