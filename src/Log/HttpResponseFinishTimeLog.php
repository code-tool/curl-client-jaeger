<?php

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResponseFinishTimeLog extends UserLog
{
    /**
     * HttpResponseFinishTimeLog constructor.
     *
     * @param int $startTime
     * @param int $finishOffset
     */
    public function __construct($startTime, $finishOffset)
    {
        parent::__construct(
            'response.finish',
            'debug',
            (string)(1000 * ($startTime + $finishOffset)),
            1000 * ($startTime + $finishOffset)
        );
    }
}
