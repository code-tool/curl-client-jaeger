<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpUploadSpeedTag extends DoubleTag
{
    /**
     * HttpUploadSpeedTag constructor.
     *
     * @param float $value
     */
    public function __construct($value)
    {
        parent::__construct('http.upload_speed', (float)$value);
    }
}
