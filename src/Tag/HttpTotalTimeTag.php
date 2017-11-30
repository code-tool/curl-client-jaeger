<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpTotalTimeTag extends DoubleTag
{
    /**
     * HttpTotalTimeTag constructor.
     *
     * @param float $value
     */
    public function __construct($value)
    {
        parent::__construct('http.total_time', (float)$value);
    }
}
