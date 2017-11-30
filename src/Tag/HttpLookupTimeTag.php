<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpLookupTimeTag extends DoubleTag
{
    public function __construct($value)
    {
        parent::__construct('http.lookup_time', (float)$value);
    }
}
