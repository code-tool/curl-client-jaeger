<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\LongTag;

class HttpDownloadSpeedTag extends LongTag
{
    public function __construct(int $value)
    {
        parent::__construct('http.download_speed', $value);
    }
}
