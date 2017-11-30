<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;
use Jaeger\Tag\LongTag;

class HttpDownloadSpeedTag extends DoubleTag
{
    /**
     * HttpDownloadSpeedTag constructor.
     *
     * @param float $value
     */
    public function __construct($value)
    {
        parent::__construct('http.download_speed', (float)$value);
    }
}
