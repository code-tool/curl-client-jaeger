<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Log;

use Jaeger\Log\UserLog;

class HttpResponseFinishTimeLog extends UserLog
{
    public function __construct(int $startTime, int $finishOffset)
    {
        parent::__construct(
            'response.finish',
            'debug',
            (string)(1000 * ($startTime + $finishOffset)),
            1000 * ($startTime + $finishOffset)
        );
    }
}
