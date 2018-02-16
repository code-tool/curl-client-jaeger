<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;
use Psr\Log\LogLevel;

class HttpResponseFinishTimeLog extends UserLog
{
    public function __construct(float $startTime, float $finishOffset)
    {
        parent::__construct(
            'response.finish',
            LogLevel::DEBUG,
            'Response received',
            (int)round(1000000 * ($startTime + $finishOffset))
        );
    }
}
