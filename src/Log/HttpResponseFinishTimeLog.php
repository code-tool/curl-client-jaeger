<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResponseFinishTimeLog extends UserLog
{
    public function __construct(float $startTime, float $finishOffset)
    {
        parent::__construct(
            'response.finish',
            'debug',
            'Response received',
            (int)round(1000000 * ($startTime + $finishOffset))
        );
    }
}
