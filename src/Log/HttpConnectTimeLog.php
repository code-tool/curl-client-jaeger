<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpConnectTimeLog extends UserLog
{
    public function __construct(int $startTime, int $connectOffset)
    {
        parent::__construct(
            'connect',
            'debug',
            (string)(1000 * ($startTime + $connectOffset)),
            1000 * ($startTime + $connectOffset)
        );
    }
}
