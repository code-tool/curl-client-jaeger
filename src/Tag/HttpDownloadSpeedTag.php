<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\LongTag;

class HttpDownloadSpeedTag extends LongTag
{
    /**
     * HttpDownloadSpeedTag constructor.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        parent::__construct('http.download_speed', (int)$value);
    }
}
