<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpPretransferTimeTag extends DoubleTag
{
    /**
     * HttpPretransferTimeTag constructor.
     *
     * @param float $value
     */
    public function __construct($value)
    {
        parent::__construct('http.pre_transfer_time', (float)$value);
    }
}
