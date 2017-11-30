<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\LongTag;

class HttpUploadSpeedTag extends LongTag
{
    /**
     * HttpUploadSpeedTag constructor.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        parent::__construct('http.upload_speed', (int)$value);
    }
}
