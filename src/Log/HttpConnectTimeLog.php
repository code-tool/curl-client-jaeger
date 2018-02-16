<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpConnectTimeLog extends UserLog
{
    public function __construct(float $startTime, float $connectOffset)
    {
        parent::__construct(
            'connect',
            'debug',
            'Connect time',
            (int)round(1000000 * ($startTime + $connectOffset))
        );
    }
}
