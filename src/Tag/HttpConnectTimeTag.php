<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpConnectTimeTag extends DoubleTag
{
    /**
     * HttpConnectTimeTag constructor.
     *
     * @param float $value
     */
    public function __construct($value)
    {
        parent::__construct('http.connect_time', (float)$value);
    }
}
