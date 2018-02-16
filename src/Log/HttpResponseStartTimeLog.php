<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResponseStartTimeLog extends UserLog
{
    public function __construct(float $startTime, float $startOffset)
    {
        parent::__construct(
            'response.start',
            'debug',
            'First byte received',
            (int)round(1000000 * ($startTime + $startOffset))
        );
    }
}
