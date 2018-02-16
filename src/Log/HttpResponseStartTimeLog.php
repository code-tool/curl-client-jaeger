<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResponseStartTimeLog extends UserLog
{
    public function __construct(int $startTime, int $startOffset)
    {
        parent::__construct(
            'response.start',
            'debug',
            (string)(1000 * ($startTime + $startOffset)),
            1000 * ($startTime + $startOffset)
        );
    }
}
