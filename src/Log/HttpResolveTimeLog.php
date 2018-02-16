<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResolveTimeLog extends UserLog
{
    public function __construct(int $startTime, int $resolveOffset)
    {
        parent::__construct(
            'resolve',
            'debug',
            (string)(1000 * ($startTime + $resolveOffset)),
            1000 * ($startTime + $resolveOffset)
        );
    }
}
