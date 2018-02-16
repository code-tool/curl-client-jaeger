<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResolveTimeLog extends UserLog
{
    public function __construct(float $startTime, float $resolveOffset)
    {
        parent::__construct(
            'resolve',
            'debug',
            (string)(1000000 * ($startTime + $resolveOffset)),
            (int)round(1000000 * ($startTime + $resolveOffset))
        );
    }
}
