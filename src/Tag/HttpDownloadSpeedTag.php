<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpDownloadSpeedTag extends DoubleTag
{
    public function __construct(float $value)
    {
        parent::__construct('http.download_speed', $value);
    }
}
